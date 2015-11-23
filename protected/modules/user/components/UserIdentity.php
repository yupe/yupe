<?php
/**
 * Файл класса UserIdentity, который расширяет возможности стандартного CUserIdentity
 *
 * @category YupeComponents
 * @package  yupe.modules.user.components
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
use yupe\models\Settings;

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
        $user = User::model()->active()->find(
            [
                'condition' => 'email = :username OR nick_name = :username',
                'params' => [
                    ':username' => $this->username,
                ],
            ]
        );

        if (null === $user) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;

            return false;
        }
        if (!Yii::app()->userManager->hasher->checkPassword($this->password, $user->hash)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;

            return false;
        }

        // запись данных в сессию пользователя
        $this->_id = $user->id;
        $this->username = $user->nick_name;

        Yii::app()->getUser()->setState('id', $user->id);
        Yii::app()->getUser()->setState(YWebUser::STATE_ACCESS_LEVEL, $user->access_level);
        Yii::app()->getUser()->setState(YWebUser::STATE_NICK_NAME, $user->nick_name);

        // для админа в сессию запишем еще несколько значений
        if ((int)$user->access_level === User::ACCESS_LEVEL_ADMIN) {
            /* Получаем настройки по всем модулям для данного пользователя: */
            $settings = Settings::model()->fetchUserModuleSettings($user->id);
            $sessionSettings = [];

            /* Если передан не пустой массив, проходим по нему: */
            if (!empty($settings) && is_array($settings)) {
                foreach ($settings as $sets) {
                    /* Наполняем нашу сессию: */
                    if (!isset($sessionSettings[$sets->module_id])) {
                        $sessionSettings[$sets->module_id] = [];
                    }

                    $sessionSettings[$sets->module_id][$sets->param_name] = $sets->param_value;
                }
            }

            Yii::app()->getUser()->setState(YWebUser::STATE_MOD_SETTINGS, $sessionSettings);
        }

        // зафиксируем время входа
        $user->visit_time = new CDbExpression('NOW()');
        $user->update(['visit_time']);
        $this->errorCode = self::ERROR_NONE;

        return true;
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
