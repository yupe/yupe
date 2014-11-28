<?php

/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
class NotifyBehavior extends CBehavior
{

    public function sendsms(User $user, $text, $sender=null)
    {
        if(!$sender)
            return Yii::app()->smsru->sms_send(
                $user->phone,
                $text,
                $sender
            );
        else
            return Yii::app()->smsru->sms_send(
                $user->phone,
                $text,
                Yii::app()->getModule('sms')->sender
            );
    }
}
