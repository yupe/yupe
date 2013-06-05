<?php
/**
 * File Doc Comment:
 * Файл класса UserIdentity, который расширяет возможности стандартного CUserIdentity
 *
 * @category YupeComponents
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/

/**
 * Файл класса UserIdentity, который расширяет возможности стандартного CUserIdentity
 *
 * @category YupeComponents
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class UserIdentity extends CUserIdentity
{
    private $_id;

    /**
     * Метод аутентификации пользователя:
     *
     * @return bool is user authenticated
     **/
    public function authenticate()
    {
        $user = User::model()->active()->findByAttributes(array('email' => $this->username));

        if ($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if (!$user->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        {
            // запись данных в сессию пользователя
            $this->_id      = $user->id;
            $this->username = $user->nick_name;

            $this->setState('id', $user->id);
            $this->setState('access_level', $user->access_level);
            $this->setState('nick_name', $user->nick_name);
            $this->setState('email', $user->email);
            $this->setState('loginTime', time());

            // для админа в сессию запишем еще несколько значений
            if ($user->access_level == User::ACCESS_LEVEL_ADMIN) {
                $this->setState('loginAdmTime', time());
                $this->setState('isAdmin', $user->access_level);

                /* Получаем настройки по всем модулям для данного пользователя: */
                $settings = Settings::model()->fetchUserModuleSettings(Yii::app()->user->getId());
                $sessionSettings = array();
                
                /* Если передан не пустой массив, проходим по нему: */
                if (!empty($settings) && is_array($settings)) {
                    foreach ($settings as $sets) {
                        /* Если есть атрибуты - продолжаем: */
                        if (isset($sets->attributes)) {
                            /* Наполняем нашу сессию: */
                            if (!isset($sessionSettings[$sets->module_id]))
                                $sessionSettings[$sets->module_id] = array();
                            $sessionSettings[$sets->module_id][$sets->param_name] = $sets->param_value;
                        }
                    }
                }
                $this->setState('modSettings', $sessionSettings);
            }

            // зафиксируем время входа
            $user->last_visit = YDbMigration::expression('NOW()');
            $user->update(array('last_visit'));

            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    /**
     * Метод получния идентификатора пльзователя:
     *
     * @return int userID
     **/
    public function getId()
    {
        return $this->_id;
    }
}