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
        $order = $event->getOrder();

        Yii::app()->orderNotifyService->sendOrderCreatedAdminNotify($order);

        Yii::app()->orderNotifyService->sendOrderCreatedUserNotify($order);
    }

    /**
     * @param Event $event
     */
    public static function onUpdate(Event $event)
    {
        $order = $event->getOrder();

        Yii::app()->orderNotifyService->sendOrderChangesNotify($order);
    }
}