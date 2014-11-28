<?php

/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
class UserManagerBehavior extends CBehavior
{

    public function changeUserPhone(User $user, $phone, $confirm = true)
    {
        if ($user->phone == $phone) {
            return true;
        }

        $transaction = Yii::app()->db->beginTransaction();

        try {

            $user->phone_confirm = User::PHONE_CONFIRM_NO;
            $user->phone = $phone;
            if ($user->save()) {
                $this->owner->tokenStorage->attachBehavior(
                        'smsBehavior' , [
                            'class' => 'application.modules.sms.behaviors.TokenStorageBehavior',
                        ]
                );

                if ($confirm && ($token = $this->owner->tokenStorage->createPhoneVerifyToken($user)) === false) {
                    throw new CException(Yii::t('UserModule.user', 'Error change Phone!'));
                }

                Yii::app()->eventManager->fire(
                    SmsEvents::SUCCESS_PHONE_CHANGE,
                    new UserPhoneConfirmEvent($token, $user)
                );

                $transaction->commit();

                return true;
            }

            throw new CException(Yii::t('UserModule.user', 'Error change Phone!'));
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }

    public function verifyPhone($token)
    {
        $transaction = Yii::app()->db->beginTransaction();

        try {
            $tokenModel = $this->owner->tokenStorage->get($token, UserToken::TYPE_PHONE_VERIFY);

            if (null === $tokenModel) {

                Yii::app()->eventManager->fire(SmsEvents::FAILURE_PHONE_CONFIRM, new UserPhoneConfirmEvent($token));

                return false;
            }

            $userModel = User::model()->active()->findByPk($tokenModel->user_id);

            if (null === $userModel) {

                Yii::app()->eventManager->fire(SmsEvents::FAILURE_PHONE_CONFIRM, new UserPhoneConfirmEvent($token));

                return false;
            }

            $userModel->phone_confirm = User::PHONE_CONFIRM_YES;

            if ($this->owner->tokenStorage->activate($tokenModel) && $userModel->save()) {

                Yii::app()->eventManager->fire(
                    SmsEvents::SUCCESS_PHONE_CONFIRM,
                    new UserPhoneConfirmEvent($token, $userModel)
                );

                $transaction->commit();

                Yii::log(
                    Yii::t(
                        'UserModule.user',
                        'Phone with activate_key = {activate_key}, id = {id} was activated!',
                        [
                            '{activate_key}' => $token,
                            '{id}'           => $userModel->id,
                        ]
                    ),
                    CLogger::LEVEL_INFO,
                    UserModule::$logCategory
                );

                return true;
            }

        } catch (Exception $e) {
            $transaction->rollback();

            Yii::app()->eventManager->fire(SmsEvents::FAILURE_PHONE_CONFIRM, new UserPhoneConfirmEvent($token));

            return false;
        }

        return false;
    }

}
