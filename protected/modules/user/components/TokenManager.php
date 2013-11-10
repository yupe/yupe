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
        $thi->storage = $storage;
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
        $token->ip = Yii::app()->getRequest()->getUserHostAddress();
        $token->status = UserToken::STATUS_NULL;
        return $token->save();
    }
}
