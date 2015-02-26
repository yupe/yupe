<?php

class PayOrderListener
{
    public static function onSuccessPay(PayOrderEvent $event)
    {
        $order = $event->getOrder();

        $order->refresh();

        $module = Yii::app()->getModule('order');

        $from = $module->notifyEmailFrom ? : Yii::app()->getModule('yupe')->email;

        //администратору
        $to = $module->getNotifyTo();

        $body = Yii::app()->getController()->renderPartial('//payment/email/newOrderAdmin', ['order' => $order], true);

        foreach ($to as $email) {
            $email = trim($email);
            if ($email) {
                Yii::app()->mail->send(
                    $from,
                    $email,
                    Yii::t(
                        'OrderModule.order',
                        'Новый заказ №{n} в магазине "{site}" .',
                        ['{n}' => $order->id, '{site}' => Yii::app()->getModule('yupe')->siteName]
                    ),
                    $body
                );
                Yii::app()->mail->reset();
            }
        }

        //пользователю
        $to = $order->email;

        $body = Yii::app()->getController()->renderPartial('//payment/email/newOrderUser', ['order' => $order], true);

        Yii::app()->mail->send(
            $from,
            $to,
            Yii::t(
                'OrderModule.order',
                'Ваш заказ №{n} в магазине "{site}" .',
                ['{n}' => $order->id, '{site}' => Yii::app()->getModule('yupe')->siteName]
            ),
            $body
        );
    }
} 
