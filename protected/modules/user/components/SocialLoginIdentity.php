<?php
class SocialLoginIdentity extends CBaseUserIdentity
{
    private $identity_id;

    private $type;

    private $_id;

    private $accessLevel;

    private $loginTime;

    private $nick_name;

    public function __construct($type, $id)
    {
        $this->identity_id = $id;
        $this->type = $type;
    }

    public function getPersistentStates()
    {
        return array(
            'id' => $this->_id,
            'accessLevel' => $this->accessLevel,
            'nick_name' => $this->nick_name,
            'loginTime' => $this->loginTime
        );
    }

    public function authenticate()
    {
        if ($this->type && $this->identity_id)
        {
            $user = Login::model()->with('user')->find('type = :type AND identity_id = :identity_id', array(
                                                                                                         ':type' => $this->type,
                                                                                                         ':identity_id' => $this->identity_id
                                                                                                    ));

            if (is_null($user) || is_null($user->user))
            {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
            elseif ($user->user->status == User::STATUS_BLOCK)
            {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
            else
            {
                $this->_id = $user->user->id;
                $this->accessLevel = $user->user->accessLevel;
                $this->nick_name = $user->user->nick_name;
                $this->loginTime = time();
                // для админа в сессию запишем еще несколько значений
                if ($user->user->accessLevel == User::ACCESS_LEVEL_ADMIN)
                {
                    Yii::app()->user->setState('loginAdmTime', time());
                    Yii::app()->user->setState('isAdmin', $user->user->accessLevel);
                }
                // зафиксируем время входа
                $user->user->lastVisit = new CDbExpression('NOW()');
                $user->user->update(array('lastVisit'));
                $this->errorCode = self::ERROR_NONE;
            }
        }

        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId()
    {
        return $this->_id;
    }
}

?>