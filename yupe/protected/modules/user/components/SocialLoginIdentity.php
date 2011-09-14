<?php
class SocialLoginIdentity extends CBaseUserIdentity
{
    private $identityId;
    
    private $type;
    
    private $_id;
    
    private $accessLevel;
    
    private $loginTime;
    
    private $nickName;
    
    public function __construct($type,$id)
    {
        $this->identityId = $id;
        $this->type       = $type;
    }
    
    public function getPersistentStates()
    {
        return array(
			'id' => $this->_id,
			'accessLevel' => $this->accessLevel,
			'nickName'    => $this->nickName,
			'loginTime'   => $this->loginTime			
		);
    }
    
    public function authenticate()
    {
        if($this->type && $this->identityId)
        {
            $user = Login::model()->with('user')->find('type = :type AND identityId = :identityId',array(
                ':type' => $this->type,
                ':identityId' => $this->identityId
            ));
            
            if(is_null($user) || is_null($user->user))
            {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
            elseif($user->user->status == User::STATUS_BLOCK)
            {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
            else
            {				
                $this->_id = $user->user->id;
                $this->accessLevel = $user->user->accessLevel;
			    $this->nickName    = $user->user->nickName;
			    $this->loginTime   = time();
				// для админа в сессию запишем еще несколько значений
				if($user->user->accessLevel == User::ACCESS_LEVEL_ADMIN)
				{
					Yii::app()->user->setState('loginAdmTime',time());
					Yii::app()->user->setState('isAdmin',$user->user->accessLevel);
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