<?php
/**
 * File Doc Comment:
 * Файл класса YWebUser, который расширяет возможности стандартного CWebUser
 *
 * @category YupeComponents
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5 (dev)
 * @link     http://yupe.ru
 *
 **/

/**
 * Файл класса YWebUser, который расширяет возможности стандартного CWebUser
 *
 * @category YupeComponents
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5 (dev)
 * @link     http://yupe.ru
 *
 **/
class YWebUser extends CWebUser
{
    private $_profile=array();

    /**
     * Инициализация компонента:
     *
     * @return parent::init()
     **/
    public function init()
    {
        $this->allowAutoLogin  = true;
        $this->authTimeout     = 24 * 3600;
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
        if (!$this->checkAccess('authenticated'))
            return false;

        $authData = $this->getAuthData();

        if ($authData['nick_name'] && $authData['loginTime'] && $authData['id'])
            return true;
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
            'nick_name'    => Yii::app()->user->getState('nick_name'),
            'loginTime'    => Yii::app()->user->getState('loginTime'),
            'id'           => (int) Yii::app()->user->getState('id'),
        );
    }

    /**
     * Метод проверки пользователя на принадлежность к админам:
     *
     * @return bool is super user
     **/
    public function isSuperUser()
    {
/*        if (!$this->isAuthenticated())
            return false;

        $loginAdmTime = Yii::app()->user->getState('loginAdmTime');
        $isAdmin      = Yii::app()->user->getState('isAdmin');

        if ($isAdmin == User::ACCESS_LEVEL_ADMIN && $loginAdmTime)
            return true;
        return false;
*/
        return Yii::app()->user->checkAccess('admin');

        throw new CException("Замени меня на задачу или действие!");
    }

    /**
     * Метод возвращающий профайл пользователя:
     *
     * @param string $moduleName - идентификатор модуля
     *
     * @todo: Добавить кеширование
     *
     * @return null || user profile
     **/
    public function getProfile($moduleName = 'user')
    {
        $className = ($moduleName=='user')?'User':(ucfirst($moduleName)."Profile");

        if (!isset($this->_profile[$moduleName]))
            $this->_profile[$moduleName] = YModel::model($className)->findByPk($this->id);

        return $this->_profile[$moduleName];
    }
}