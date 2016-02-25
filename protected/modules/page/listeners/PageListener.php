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
        Yii::app()->getCache()->clear([PageRoute::CACHE_TAG_NAME]);
    }
}