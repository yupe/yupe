<?php

class TokenStorage extends CApplicationComponent
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
        if($model->save()) {
            return $model;
        }

        return false;
    }

    public function createAccountActivationToken(User $user, $expire=86400)
    {
        return $this->create($user, $expire, UserToken::TYPE_ACTIVATE);
    }

    public function createPasswordRecoveryToken(User $user, $expire=86400)
    {
        return $this->create($user, $expire, UserToken::TYPE_CHANGE_PASSWORD);
    }

    public function createEmailVerifyToken(User $user, $expire=86400)
    {
        return $this->create($user, $expire, UserToken::TYPE_EMAIL_VERIFY);
    }

    public function get($token, $type, $status = UserToken::STATUS_NEW)
    {
        return UserToken::model()->find('token = :token AND type = :type AND status = :status', array(
            ':token'  => $token,
            ':type'   => (int)$type,
            ':status' => (int)$status
        ));
    }

    public function activate(UserToken $token, $invalidate = true)
    {
        $token->status = UserToken::STATUS_ACTIVATE;

        if($token->save()) {
            if($invalidate) {
                UserToken::model()->updateAll(array('status' => UserToken::STATUS_FAIL),'id != :id AND user_id = :user_id AND type = :type', array(
                    ':user_id' => $token->user_id,
                    ':type' => $token->type,
                    ':id' => $token->id
                ));
            }

            return true;
        }

        throw new CDbException(Yii::t('UserModule.user','Error activate token!'));
    }
}
