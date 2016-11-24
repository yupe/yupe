<?php
use yupe\components\Event;

/**
 * Class CategoryListener
 */
class CategoryListener
{
    /**
     * onAfterSave event listener
     *
     * @param Event $event
     */
    public static function onAfterSave(Event $event)
    {
        Yii::app()->getCache()->clear([CategoryHelper::CATEGORY_CACHE_TAG]);
    }

    /**
     * @param Event $event
     */
    public static function onAfterDelete(Event $event)
    {
        Yii::app()->getCache()->clear([CategoryHelper::CATEGORY_CACHE_TAG]);
    }

}