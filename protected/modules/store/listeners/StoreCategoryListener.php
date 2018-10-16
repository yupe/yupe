<?php
use yupe\components\Event;

/**
 * Class StoreCategoryListener
 */
class StoreCategoryListener
{
    /**
     * onAfterSave event listener
     *
     * @param Event $event
     */
    public static function onAfterSave(Event $event)
    {
        Yii::app()->getCache()->clear([StoreCategoryHelper::CACHE_CATEGORY_TAG]);
    }

    /**
     * @param Event $event
     */
    public static function onAfterDelete(Event $event)
    {
        Yii::app()->getCache()->clear([StoreCategoryHelper::CACHE_CATEGORY_TAG]);
    }
}