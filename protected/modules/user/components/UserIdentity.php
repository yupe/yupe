<?php
class UserIdentity extends CUserIdentity
{
    private $_id;

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

            Yii::app()->user->setState('id', $user->id);
            Yii::app()->user->setState('access_level', $user->access_level);
            Yii::app()->user->setState('nick_name', $user->nick_name);
            Yii::app()->user->setState('email', $user->email);
            Yii::app()->user->setState('loginTime', time());

            // для админа в сессию запишем еще несколько значений
            if ($user->access_level == User::ACCESS_LEVEL_ADMIN)
            {
                Yii::app()->user->setState('loginAdmTime', time());
                Yii::app()->user->setState('isAdmin', $user->access_level);

                /* Получаем настройки по всем модулям для данного пользователя: */
                $settings = Settings::model()->fetchUserModuleSettings(Yii::app()->user->id);
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
                Yii::app()->session['modSettings'] = $sessionSettings;
            }

            // зафиксируем время входа
            $user->last_visit = new CDbExpression('NOW()');
            $user->update(array('last_visit'));

            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId()
    {
        return $this->_id;
    }
}