<?php

/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
class TokenStorageBehavior extends CBehavior
{

    public function createPhoneVerifyToken(User $user, $expire = 86400)
    {
        $this->owner->deleteByTypeAndUser(UserToken::TYPE_PHONE_VERIFY, $user);

        $model = $this->owner->create($user, $expire, UserToken::TYPE_PHONE_VERIFY);

        $model->token=(string)(crc32($model->token));

        $model->save();

        return $model;
    }

}
