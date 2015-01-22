<?php

class OrderNotifyService extends CApplicationComponent
{
    public $mail;

    protected $view;

    protected $module;

    public function init()
    {
        parent::init();

        if ($this->mail && Yii::app()->hasComponent($this->mail)) {
            $this->mail = Yii::app()->getComponent('mail');
        } else {
            $this->mail = Yii::app()->mail;
        }

        $this->view = Yii::app()->controller;

        $this->module = Yii::app()->getModule('order');
    }

    public function sendOrderCreatedAdminNotify(Order $order)
    {
        $from = $this->module->notifyEmailFrom ? : Yii::app()->getModule('yupe')->email;

        $theme = Yii::t(
            'OrderModule.order',
            'Новый заказ №{n} в магазине {site}',
            ['{n}' => $order->id, '{site}' => Yii::app()->getModule('yupe')->siteName]
        );

        $to = $this->module->getNotifyTo();

        $body = $this->view->renderPartial('/order/email/newOrderAdmin', ['order' => $order], true);

        foreach ($to as $email) {
            $this->mail->send($from, $email, $theme, $body);
        }

        return true;
    }

    public function sendOrderCreatedUserNotify(Order $order)
    {
        $theme = Yii::t(
            'OrderModule.order',
            'Новый заказ №{n} в магазине {site}',
            ['{n}' => $order->id, '{site}' => Yii::app()->getModule('yupe')->siteName]
        );

        $from = $this->module->notifyEmailFrom ? : Yii::app()->getModule('yupe')->email;

        $body = $this->view->renderPartial('/order/email/newOrderUser', ['order' => $order], true);

        $this->mail->send($from, $order->email, $theme, $body);
    }

    public function sendOrderChangesNotify(Order $order)
    {
        $theme = Yii::t(
            'OrderModule.order',
            'Изменение заказа №{n} в магазине {site}',
            ['{n}' => $order->id, '{site}' => Yii::app()->getModule('yupe')->siteName]
        );

        $from = $this->module->notifyEmailFrom ? : Yii::app()->getModule('yupe')->email;

        $body = $this->view->renderPartial('/order/email/orderChangeStatus', ['order' => $order], true);

        $this->mail->send($from, $order->email, $theme, $body);
    }
} 
