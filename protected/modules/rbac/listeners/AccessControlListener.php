<?php

use yupe\components\Event;

class AccessControlListener
{
    public static function onBackendControllerInit(Event $event)
    {
        Yii::app()->getModule('yupe')->addbackendFilter('accessControl');
    }
} 