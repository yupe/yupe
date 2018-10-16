<?php
use yupe\components\Event;

/**
 * Class PageListener
 */
class PageListener
{
    /**
     * onAfterSave event listener
     *
     * @param Event $event
     */
    public static function onAfterSave(Event $event)
    {
        Yii::app()->cache->delete(PageUrlRule::CACHE_KEY);
    }
}