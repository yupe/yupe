<?php
use yupe\components\Event;

class BlogJoinLeaveListener
{
    public static function onJoin(Event $event)
    {
        Yii::log("User {$event->getUserId()} join blog {$event->getBlog()->name}...!!!!!", CLogger::LEVEL_ERROR);
    }

    public static function onLeave(Event $event)
    {
        Yii::log("User {$event->getUserId()} leave blog {$event->getBlog()->name}...!!!!!", CLogger::LEVEL_ERROR);
    }
}
