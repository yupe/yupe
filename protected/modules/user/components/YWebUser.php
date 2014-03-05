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
    private $_profile;

    /**
     * Инициализация компонента:
     *
     * @return parent::init()
     **/
    public function init()
    {
        $this->allowAutoLogin  = true;
        $this->authTimeout     = 24 * 2600;
        $this->autoRenewCookie = true;

        $this->loginUrl = Yii::app()->createUrl($this->loginUrl);

        return parent::init();
    }

    /**
     * Метод который проверяет, авторизирован ли пользователь:
     *
     * @return bool авторизирован ли пользователь
     **/
    public function isAuthenticated()
    {
        if ($this->getIsGuest()) {
            return false;
        }

        $authData = $this->getAuthData();

        if ($authData['nick_name'] && isset($authData['access_level']) && $authData['loginTime'] && $authData['id']) {
            return true;
        }

        return false;
    }

    /**
     * Возвращаем данные по авторизации:
     *
     * @return mixed authdata
     **/
    protected function getAuthData()
    {
        return array(
            'nick_name'    => $this->getState('nick_name'),
            'access_level' => (int) $this->getState('access_level'),
            'loginTime'    => $this->getState('loginTime'),
            'id'           => (int) $this->getState('id'),
        );
    }

    /**
     * Метод проверки пользователя на принадлежность к админам:
     *
     * @return bool is super user
     **/
    public function isSuperUser()
    {
        if (!$this->isAuthenticated()){
            return false;
        }

        $loginAdmTime = $this->getState('loginAdmTime');
        $isAdmin      = $this->getState('isAdmin');

        if ((int)$isAdmin === User::ACCESS_LEVEL_ADMIN && $loginAdmTime){
            return true;
        }

        return false;
    }

    /**
     * Метод возвращающий профайл пользователя:
     *
     * @param string $id  - идентификатор пользователя
     * @param string $moduleName   - идентификатор модуля
     *
     * @return User|null - Модель пользователя в случае успеха, иначе null
     */
    public function getProfile($id = null,$moduleName = null)
    {
        if ($moduleName) {
            return null;
        }

        $id = $id === null ? $this->id : $id;

        if ( null === $this->_profile ) {
            $this->_profile = User::model()->active()->findByPk($id);
        }

        return $this->_profile;
    }

    public function getFullName($separator = ' ')
    {
        if(Yii::app()->getUser()->hasState('full_name')) {
            return Yii::app()->getUser()->getState('full_name');
        }

        $profile = $this->getProfile();

        $fullName = Yii::app()->getUser()->getState('nick_name');

        if(!empty($profile->last_name) && !empty($profile->first_name)){
            $fullName =  $profile->first_name.$separator.$profile->last_name;
        }

        Yii::app()->getUser()->setState('full_name', $fullName);

        return $fullName;
    }

    public function getAvatar($size = 64)
    {
        $size = (int)$size;

        $avatars = Yii::app()->getUser()->getState('avatars');

        if(!empty($avatars) && !empty($avatars[$size])) {
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

        return parent::afterLogout();
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

        return parent::afterLogin($fromCookie);
    }
}