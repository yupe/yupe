<?php
use yupe\components\Event;

/**
 * Class NewsListener
 */
class NewsListener
{
    /**
     * onAfterSave event listener
     *
     * @param Event $event
     */
    public static function onAfterSave(Event $event)
    {
        Yii::app()->getCache()->clear([NewsHelper::CACHE_NEWS_TAG]);
    }

    /**
     * @param Event $event
     */
    public static function onAfterDelete(Event $event)
    {
        Yii::app()->getCache()->clear([NewsHelper::CACHE_NEWS_TAG]);
    }

}