<?php

class UserIdentity extends CUserIdentity
{

    private $_id;

    public function authenticate()
    {
        $user = User::model()->active()->findByAttributes(array('email' => $this->username));

        if ($user === null)
        {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        elseif (!$user->validatePassword($this->password))
        {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        else
        {
            // запись данных в сессию пользователя
            $this->_id = $user->id;
            $this->username = $user->nickName;
            Yii::app()->user->setState('id', $user->id);
            Yii::app()->user->setState('accessLevel', $user->accessLevel);
            Yii::app()->user->setState('nickName', $user->nickName);
            Yii::app()->user->setState('email', $user->email);
            Yii::app()->user->setState('loginTime', time());
            // для админа в сессию запишем еще несколько значений
            if ($user->accessLevel == User::ACCESS_LEVEL_ADMIN)
            {
                Yii::app()->user->setState('loginAdmTime', time());
                Yii::app()->user->setState('isAdmin', $user->accessLevel);
            }

            // зафиксируем время входа
            $user->lastVisit = new CDbExpression('NOW()');
            $user->update(array('lastVisit'));

            $this->errorCode = self::ERROR_NONE;
        }

        return $this->errorCode == self::ERROR_NONE;
    }


    public function getId()
    {
        return $this->_id;
    }
}