<?php

use yupe\components\Event;

/**
 * Class OrderListener
 */
class OrderListener
{
    /**
     * @param Event $event
     */
    public static function onCreate(Event $event)
    {
        if (Yii::app()->hasModule('cart')) {
            Yii::app()->cart->clear();
        }

        $order = $event->getOrder();

        Yii::app()->orderNotifyService->sendOrderCreatedAdminNotify($order);

        Yii::app()->orderNotifyService->sendOrderCreatedUserNotify($order);
    }
}