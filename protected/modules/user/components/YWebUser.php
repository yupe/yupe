<?php

/**
 * Файл класса YWebUser, который расширяет возможности стандартного CWebUser
 *
 * @category YupeComponents
 * @package  yupe.modules.user.components
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class YWebUser extends CWebUser
{
    /**
     *
     */
    const STATE_ACCESS_LEVEL = 'access_level';

    /**
     *
     */
    const STATE_NICK_NAME = 'nick_name';

    /**
     *
     */
    const STATE_MOD_SETTINGS = 'modSettings';

    /**
     *
     */
    const STATE_ADM_CHECK_ATTEMPT = 'adm_check_attempt';

    /**
     * @var array
     */
    protected $_profiles = [];

    /**
     * @var int
     */
    public $authTimeout = 62400;

    /**
     * @var bool
     */
    public $autoRenewCookie = true;

    /**
     * @var bool
     */
    public $allowAutoLogin = true;

    /**
     * @var int
     */
    public $attempt = 10;

    /**
     * @var string
     */
    public $authToken = 'at';

    /**
     * @var string
     * @since 0.8
     */
    public $rbacCacheNameSpace = 'yupe::user::rbac::';

    /**
     * Метод который проверяет, авторизирован ли пользователь:
     *
     * @return bool авторизирован ли пользователь
     **/
    public function isAuthenticated()
    {
        return !$this->getIsGuest();
    }

    /**
     * Метод проверки пользователя на принадлежность к админам:
     *
     * @return bool is super user
     **/
    public function isSuperUser()
    {
        if (!$this->isAuthenticated()) {
            return false;
        }

        $attempt = (int)Yii::app()->getUser()->getState(self::STATE_ADM_CHECK_ATTEMPT, 0);

        if ($attempt >= $this->attempt) {

            $attempt = 0;

            $user = User::model()->active()->find(
                'id = :id AND access_level = :level',
                [
                    ':level' => User::ACCESS_LEVEL_ADMIN,
                    ':id' => $this->getId()
                ]
            );

            if (null === $user) {
                return false;
            }
        }

        Yii::app()->getUser()->setState(self::STATE_ADM_CHECK_ATTEMPT, ++$attempt);

        return (int)Yii::app()->getUser()->getState(self::STATE_ACCESS_LEVEL) === User::ACCESS_LEVEL_ADMIN;
    }

    /**
     * Метод возвращающий профайл пользователя:
     *s
     * @param  string $moduleName - идентификатор модуля
     * @throws CException
     * @return User|null  - Модель пользователя в случае успеха, иначе null
     */
    public function getProfile($moduleName = 'yupe')
    {
        if (isset($this->_profiles[$moduleName])) {
            return $this->_profiles[$moduleName];
        }

        $module = Yii::app()->getModule($moduleName);

        if (null === $module) {
            throw new CException(Yii::t(
                'YupeModule.yupe',
                'Module "{module}" not found!',
                [
                    '{module}' => $moduleName
                ]
            ));
        }

        $model = $module->getProfileModel();

        if (false === $model) {
            throw new CException(Yii::t(
                'YupeModule.yupe',
                'Module "{module}" has no profile model!',
                [
                    '{module}' => $moduleName
                ]
            ));
        }

        $this->_profiles[$moduleName] = CActiveRecord::model($model)->findByPk($this->id);

        return $this->_profiles[$moduleName];
    }

    /**
     * @param $field
     * @param  string $module
     * @return array|mixed|null
     */
    public function getProfileField($field, $module = 'yupe')
    {
        if (Yii::app()->getUser()->hasState($field)) {
            return Yii::app()->getUser()->getState($field);
        }

        $profile = $this->getProfile($module);

        if (null === $profile) {
            return null;
        }

        $value = $profile->$field;

        Yii::app()->getUser()->setState($field, $value);

        return $value;
    }

    /**
     * @param  int $size
     * @return mixed
     */
    public function getAvatar($size = 64)
    {
        $size = (int)$size;

        $avatars = Yii::app()->getUser()->getState('avatars');

        if (!empty($avatars) && !empty($avatars[$size])) {
            return $avatars[$size];
        }

        $avatars = [];

        $profile = $this->getProfile();

        $avatars[$size] = $profile->getAvatar($size);

        Yii::app()->getUser()->setState('avatars', $avatars);

        return $avatars[$size];
    }

    /**
     * Метод для действий после выхода из системы:
     *
     * @return parent::afterLogout()
     */
    protected function afterLogout()
    {
        Yii::app()->getCache()->clear('loggedIn' . $this->getId());

        parent::afterLogout();
    }

    /**
     * Метод для действий после входа в систему:
     *
     * @param boolean $fromCookie - is authorize from cookie
     *
     * @return parent::afterLogin()
     */
    protected function afterLogin($fromCookie)
    {
        Yii::app()->getCache()->clear('loggedIn' . $this->getId());

        if ($fromCookie) {

            $transaction = Yii::app()->getDb()->beginTransaction();

            try {

                $user = User::model()->active()->findByPk($this->getId());

                if (null === $user) {
                    $this->logout();

                    return false;
                }


                //перегенерировать токен авторизации
                $token = Yii::app()->userManager->tokenStorage->createCookieAuthToken(
                    $user,
                    (int)Yii::app()->getModule('user')->sessionLifeTime * 24 * 60 * 60
                );

                $this->setState($this->authToken, $token->token);
                $this->setState(self::STATE_ACCESS_LEVEL, $user->access_level);
                $this->setState(self::STATE_NICK_NAME, $user->nick_name);

                //дата входа
                $user->visit_time = new CDbExpression('NOW()');
                $user->update(['visit_time']);

                $transaction->commit();

            } catch (Exception $e) {
                $transaction->rollback();
            }
        }

        parent::afterLogin($fromCookie);
    }

    /**
     * @param  mixed $id
     * @param  array $states
     * @param  bool $fromCookie
     * @return bool
     */
    public function beforeLogin($id, $states, $fromCookie)
    {
        if (!$fromCookie) {
            return parent::beforeLogin($id, $states, $fromCookie);
        }

        //проверить токен авторизации
        $token = isset($states[$this->authToken]) ? $states[$this->authToken] : null;

        if (empty($token)) {
            return false;
        }

        $model = Yii::app()->userManager->tokenStorage->get($token, UserToken::TYPE_COOKIE_AUTH);

        if (null === $model) {
            return false;
        }

        return true;
    }


    /**
     * @param  IUserIdentity $identity
     * @param  int $duration
     * @return bool
     */
    public function login($identity, $duration = 0)
    {
        if ($duration) {
            //создать токен
            $token = Yii::app()->userManager->tokenStorage->createCookieAuthToken(
                $this->getProfile(),
                $duration
            );

            $identity->setState($this->authToken, $token->token);
        }

        return parent::login($identity, $duration);
    }
}
