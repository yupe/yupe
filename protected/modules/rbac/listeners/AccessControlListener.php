<?php

use yupe\components\Event;

class AccessControlListener
{
    public static function onBackendControllerInit(Event $event)
    {
        //ддинамически добавляем фильтр контроля доступа для RBAC
        Yii::app()->getModule('yupe')->addbackendFilter('accessControl');
    }
} 