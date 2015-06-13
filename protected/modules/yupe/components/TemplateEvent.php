<?php

namespace yupe\components;

use Yii;

class TemplateEvent
{

    public static function fire($eventName, Event $event = null)
    {
        if(null === $event) {
            $event = new Event();
        }

        Yii::app()->eventManager->fire($eventName, $event);
    }
}