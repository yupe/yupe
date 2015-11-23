<?php

namespace yupe\components;

use Yii;

/**
 * Class TemplateEvent
 * @package yupe\components
 */
class TemplateEvent
{

    public static function fire($eventName, Event $event = null)
    {
        if (null === $event) {
            $event = new Event();
        }

        Yii::app()->eventManager->fire($eventName, $event);
    }
}