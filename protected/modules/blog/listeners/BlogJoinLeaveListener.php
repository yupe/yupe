<?php
use yupe\components\Event;

/**
 * Class BlogJoinLeaveListener
 */
class BlogJoinLeaveListener
{
    /**
     * @param Event $event
     */
    public static function onJoin(Event $event)
    {
        Yii::log("User {$event->getUserId()} join blog {$event->getBlog()->name}...!!!!!", CLogger::LEVEL_ERROR);
    }

    /**
     * @param Event $event
     */
    public static function onLeave(Event $event)
    {
        Yii::log("User {$event->getUserId()} leave blog {$event->getBlog()->name}...!!!!!", CLogger::LEVEL_ERROR);
    }
}
