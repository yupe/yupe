<?php

class DbTokenStorage extends CApplicationComponent
{
    public function create(User $user, $expire, $type)
    {
        $model = new UserToken;
        $model->user_id = $user->id;
        $model->type = (int)$type;
        //@TODO
        $model->token = Yii::app()->userManager->hasher->generateRandomToken();
        //@TODO 
        $model->ip = Yii::app()->getRequest()->getUserHostAddress();
        $model->status = UserToken::STATUS_NEW;
        return $model->save();
    }

    public function createAccountActivationToken(User $user, $expire=86400)
    {
        return $this->create($user, $expire, UserToken::TYPE_ACTIVATE);
    }


    public function get($token, $type, $status = UserToken::STATUS_NEW)
    {
        return  UserToken::model()->find('token = :token AND type = :type AND status = :status', array(
            ':token'  => $token,
            ':type'   => (int)$type,
            ':status' => (int)$status
        ));
    }
}
