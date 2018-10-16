<?php

use yupe\components\Event;

class ViewedProductListener extends Event
{
    public static function onOpening(Event $event)
    {
        $product = $event->getProduct();

        Yii::app()->viewed->add($product->id);
    }
}