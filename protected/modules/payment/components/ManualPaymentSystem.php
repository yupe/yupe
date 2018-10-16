<?php

/**
 * Class ManualPaymentSystem
 */
class ManualPaymentSystem extends PaymentSystem
{
    /**
     * @var null
     */
    public $parametersFile = null;

    /**
     * @param Payment $payment
     * @param Order $order
     * @param bool $return
     * @return mixed|string
     */
    public function renderCheckoutForm(Payment $payment, Order $order, $return = false)
    {
        return Yii::app()->getController()->renderPartial('application.modules.payment.views.form', [
            'payment' => $payment,
            'order' => $order,
        ], $return);
    }

    /**
     * @param array $paymentSettings
     * @param bool $return
     * @return null
     */
    public function renderSettings($paymentSettings = [], $return = false)
    {
        return null;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return ['name' => Yii::t('PaymentModule.payment', 'Manual processing')];
    }


    /**
     * @param Payment $payment
     * @param CHttpRequest $request
     * @return bool|static
     */
    public function processCheckout(Payment $payment, CHttpRequest $request)
    {
        $orderId = (int)$request->getPost('order');

        if (!$orderId) {
            return false;
        }

        $order = Order::model()->findByPk($orderId);

        if (null === $order) {
            return false;
        }

        if ($order->pay($payment, Order::PAID_STATUS_NOT_PAID)) {
            return $order;
        }

        return false;
    }
}