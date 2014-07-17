<?php

use yupe\components\Event;

class AccessControlListener
{
    public static function onBeforeBackendControllerAction(Event $event)
    {
       $filter = new CAccessControlFilter;
       $filter->setRules($event->getController()->accessRules());
    }
} 