<?php

use yupe\widgets\YFlashMessages;

Yii::import('application.modules.payler.PaylerModule');
Yii::import('application.modules.payler.components.Payler');

class PaylerPaymentSystem extends PaymentSystem
{
    public function renderCheckoutForm(Payment $payment, Order $order, $return = false)
    {
        $payler = new Payler($payment);
        $sessionId = $payler->getSessionId($order);

        if (!$sessionId) {
            Yii::app()->getUser()->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('PaylerModule.payler', 'Payment by "{name}" is impossible', ['{name}' => $payment->name])
            );

            return false;
        }

        return Yii::app()->getController()->renderPartial('application.modules.payler.views.form', [
            'action' => $payler->getUrl('Pay'),
            'sessionId' => $sessionId
        ], $return);
    }

    public function processCheckout(Payment $payment, CHttpRequest $request)
    {
        $payler = new Payler($payment);
        $order = Order::model()->findByUrl($payler->getOrderIdFromHash($request));

        if ($order === null) {
            Yii::log(Yii::t('PaylerModule.payler', 'The order doesn\'t exist.'), CLogger::LEVEL_ERROR);

            return false;
        }

        if ($order->isPaid()) {
            Yii::log(
                Yii::t('PaylerModule.payler', 'The order #{n} is already payed.', $order->getPrimaryKey()),
                CLogger::LEVEL_ERROR
            );

            return $order;
        }

        if ($payler->getPaymentStatus($request) === 'Charged' && $order->pay($payment)) {
            Yii::log(
                Yii::t('PaylerModule.payler', 'The order #{n} has been payed successfully.', $order->getPrimaryKey()),
                CLogger::LEVEL_INFO
            );
        } else {
            Yii::app()->getUser()->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('PaylerModule.payler', 'Attempt to pay failed')
            );
            Yii::log(Yii::t('PaylerModule.payler', 'An error occurred when you pay the order #{n}.',
                $order->getPrimaryKey()), CLogger::LEVEL_ERROR);
        }

        return $order;
    }
}