<?php
class TokenManager extends CApplicationComponent
{
    public $storage;
    
    public function init()
    {
        $this->setStorage(Yii::createComponent($this->storage));
        
        parent::init();
    }
    
    public function setStorage(DbTokenStorage $storage)
    {
        $this->storage = $storage;
    }
    
    public function createAccountActivationToken(User $user, $expire = 3600)
    {
        return $this->createToken($user, $expire, UserToken::TYPE_ACTIVATE);                
    }
    
    protected function createToken(User $user, $expire, $type = UserToken::TYPE_ACTIVATE)
    {
        $model = new UserToken;
        $model->user_id = $user->id;
        $model->type = $type;
        //@TODO
        $model->token = Yii::app()->userManager->hasher->generateRandomToken();
        //@TODO 
        $model->ip = Yii::app()->getRequest()->getUserHostAddress();
        $model->status = UserToken::STATUS_NEW;
        return $model->save();
    }

    public function getToken($token, $type, $status = UserToken::STATUS_NEW)
    {
        return  UserToken::model()->find('token = :token AND type = :type AND status = :status', array(
            ':token'  => $token,
            ':type'   => (int)$type,
            ':status' => (int)$status
        ));
    }
}
