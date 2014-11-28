<?php
/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
class SmsListener
{
    public static function onSuccessPhoneChange(UserPhoneConfirmEvent $event)
    {
        Yii::app()->notify->sendsms(
            $event->getUser(),
            Yii::t('UserModule.user', 'Phone verification code: ').($event->getToken()->token)
        );
    }

    public static function onSuccessPhoneConfirm(UserPhoneConfirmEvent $event)
    {
        Yii::app()->notify->sendsms(
            $event->getUser(),
            Yii::t('UserModule.user', 'Phone verification succeed')
        );
    }
}
