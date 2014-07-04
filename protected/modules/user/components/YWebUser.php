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
    const STATE_ACCESS_LEVEL = 'access_level';

    const STATE_NICK_NAME = 'nick_name';

    const STATE_MOD_SETTINGS = 'modSettings';

    const STATE_ADM_CHECK_ATTEMPT = 'adm_check_attempt';

    private $_profiles = array();

    public $authTimeout = 62400;

    public $autoRenewCookie = true;

    public $allowAutoLogin = true;

    public $attempt = 5;

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
                array(
                    ':level' => User::ACCESS_LEVEL_ADMIN,
                    ':id' => $this->getId()
                )
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
     * @param string $moduleName - идентификатор модуля
     * @throw CException
     * @return User|null - Модель пользователя в случае успеха, иначе null
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
                array(
                    '{module}' => $moduleName
                )
            ));
        }

        $model = $module->getProfileModel();

        if(false === $model) {
            throw new CException(Yii::t(
                'YupeModule.yupe',
                'Module "{module}" has no profile model!',
                array(
                    '{module}' => $moduleName
                )
            ));
        }

        $this->_profiles[$moduleName] = CActiveRecord::model($model)->findByPk($this->id);

        return $this->_profiles[$moduleName];
    }

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

    public function getAvatar($size = 64)
    {
        $size = (int)$size;

        $avatars = Yii::app()->getUser()->getState('avatars');

        if (!empty($avatars) && !empty($avatars[$size])) {
            return $avatars[$size];
        }

        $avatars = array();

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
        Yii::app()->cache->clear('loggedIn' . $this->getId());

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
        Yii::app()->cache->clear('loggedIn' . $this->getId());

        if (true === $fromCookie) {

            $user = User::model()->active()->findByPk((int)$this->getId());

            if (null === $user) {

                $this->logout();

                return false;
            }

            $this->setState(self::STATE_ACCESS_LEVEL, $user->access_level);
            $this->setState(self::STATE_NICK_NAME, $user->nick_name);
        }

        parent::afterLogin($fromCookie);
    }
}