<?php

/**
 * Class OrderNotifyService
 */
class OrderNotifyService extends CApplicationComponent
{
    /**
     * @var
     */
    public $mail;

    /**
     * @var
     */
    protected $view;

    /**
     * @var
     */
    protected $module;

    /**
     *
     */
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

    /**
     * @param Order $order
     * @return bool
     */
    public function sendOrderCreatedAdminNotify(Order $order)
    {
        $from = $this->module->notifyEmailFrom ?: Yii::app()->getModule('yupe')->email;

        $theme = Yii::t(
            'OrderModule.order',
            'New order #{n} in {site} store',
            ['{n}' => $order->id, '{site}' => Yii::app()->getModule('yupe')->siteName]
        );

        $to = $this->module->getNotifyTo();

        $body = $this->view->renderPartial('/order/email/newOrderAdmin', ['order' => $order], true);

        foreach ($to as $email) {
            $this->mail->send($from, $email, $theme, $body);
        }

        return true;
    }

    /**
     * @param Order $order
     */
    public function sendOrderCreatedUserNotify(Order $order)
    {
        $theme = Yii::t(
            'OrderModule.order',
            'New order #{n} in {site} store',
            ['{n}' => $order->id, '{site}' => Yii::app()->getModule('yupe')->siteName]
        );

        $from = $this->module->notifyEmailFrom ?: Yii::app()->getModule('yupe')->email;

        $body = $this->view->renderPartial('/order/email/newOrderUser', ['order' => $order], true);

        $this->mail->send($from, $order->email, $theme, $body);
    }

    /**
     * @param Order $order
     */
    public function sendOrderChangesNotify(Order $order)
    {
        $theme = Yii::t(
            'OrderModule.order',
            'Order #{n} in {site} store is changed',
            ['{n}' => $order->id, '{site}' => Yii::app()->getModule('yupe')->siteName]
        );

        $from = $this->module->notifyEmailFrom ?: Yii::app()->getModule('yupe')->email;

        $body = $this->view->renderPartial('/order/email/orderChangeStatus', ['order' => $order], true);

        $this->mail->send($from, $order->email, $theme, $body);
    }
} 
