<?php
Yii::import('application.modules.manualpay.ManualPayModule');

class ManualPaymentSystem extends PaymentSystem
{
    public function renderCheckoutForm(Payment $payment, Order $order, $return = false)
    {
        return Yii::app()->getController()->renderPartial('application.modules.manualpay.views.form', [
            'action' => Yii::app()->createAbsoluteUrl('/payment/payment/process', ['id' => $payment->id]),
            'orderId' => $order->id
        ], $return);
    }

    public function processCheckout(Payment $payment, CHttpRequest $request)
    {
        $orderId = (int)$request->getParam('orderId');
        $order = Order::model()->findByPk($orderId);

        if (null === $order) {
            Yii::log(Yii::t('ManualPayModule.manual', 'Order with id = {id} not found!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
            return false;
        }

        $order->payment_method_id = $payment->id;
        $order->status_id = OrderStatus::STATUS_APPROVED;

        if ($order->save()) {
            Yii::log(
                Yii::t('ManualPayModule.manual', 'The order #{n} has been payed successfully.', $order->getPrimaryKey()),
                CLogger::LEVEL_INFO
            );

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('OrderModule.order', 'Your order approved')
            );
        }

        return $order;
    }
}