<?php

/**
 * Class TokenStorage
 */
class TokenStorage extends CApplicationComponent
{
    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->deleteExpired();
    }

    /**
     * @param User $user
     * @param $expire
     * @param $type
     * @return bool|UserToken
     */
    public function create(User $user, $expire, $type)
    {
        $expire = (int)$expire;
        $model = new UserToken();
        $model->user_id = $user->id;
        $model->type = (int)$type;
        $model->token = Yii::app()->userManager->hasher->generateRandomToken();
        $model->ip = Yii::app()->getRequest()->getUserHostAddress();
        $model->status = UserToken::STATUS_NEW;
        $model->expire_time = new CDbExpression("DATE_ADD(NOW(), INTERVAL {$expire} SECOND)");
        if ($model->save()) {
            return $model;
        }

        return false;
    }

    /**
     * @param $type
     * @param User $user
     * @return int
     */
    public function deleteByTypeAndUser($type, User $user)
    {
        return UserToken::model()->deleteAll(
            'type = :type AND user_id = :user_id',
            [
                ':type' => (int)$type,
                ':user_id' => $user->id,
            ]
        );
    }

    /**
     * @return int
     */
    public function deleteExpired()
    {
        $deleted = UserToken::model()->deleteAll('expire < NOW()');

        Yii::log(sprintf('Delete %d tokes', $deleted), Clogger::LEVEL_INFO);

        return $deleted;
    }

    /**
     * @param User $user
     * @param int $expire
     * @return bool|UserToken
     */
    public function createAccountActivationToken(User $user, $expire = 86400)
    {
        $this->deleteByTypeAndUser(UserToken::TYPE_ACTIVATE, $user);

        return $this->create($user, $expire, UserToken::TYPE_ACTIVATE);
    }

    /**
     * @param User $user
     * @param int $expire
     * @return bool|UserToken
     */
    public function createPasswordRecoveryToken(User $user, $expire = 86400)
    {
        $this->deleteByTypeAndUser(UserToken::TYPE_CHANGE_PASSWORD, $user);

        return $this->create($user, $expire, UserToken::TYPE_CHANGE_PASSWORD);
    }

    /**
     * @param User $user
     * @param int $expire
     * @return bool|UserToken
     */
    public function createEmailVerifyToken(User $user, $expire = 86400)
    {
        $this->deleteByTypeAndUser(UserToken::TYPE_EMAIL_VERIFY, $user);

        return $this->create($user, $expire, UserToken::TYPE_EMAIL_VERIFY);
    }

    /**
     * @param User $user
     * @param int $expire
     * @return bool|UserToken
     */
    public function createCookieAuthToken(User $user, $expire = 86400)
    {
        $this->deleteByTypeAndUser(UserToken::TYPE_COOKIE_AUTH, $user);

        return $this->create($user, $expire, UserToken::TYPE_COOKIE_AUTH);
    }

    /**
     * @param $token
     * @param $type
     * @param int $status
     * @return static
     */
    public function get($token, $type, $status = UserToken::STATUS_NEW)
    {
        return UserToken::model()->find(
            'token = :token AND type = :type AND status = :status',
            [
                ':token' => $token,
                ':type' => (int)$type,
                ':status' => (int)$status,
            ]
        );
    }

    /**
     * @param UserToken $token
     * @param bool|true $invalidate
     * @return bool
     * @throws CDbException
     */
    public function activate(UserToken $token, $invalidate = true)
    {
        $token->status = UserToken::STATUS_ACTIVATE;

        if ($token->save()) {
            if ($invalidate) {
                UserToken::model()->deleteAll(
                    'id != :id AND user_id = :user_id AND type = :type',
                    [
                        ':user_id' => $token->user_id,
                        ':type' => $token->type,
                        ':id' => $token->id,
                    ]
                );
            }

            return true;
        }

        throw new CDbException(Yii::t('UserModule.user', 'Error activate token!'));
    }
}
