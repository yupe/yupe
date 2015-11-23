<?php

/**
 * Class RobokassaPaymentSystem
 * @link http://www.robokassa.ru/ru/Doc/Ru/Interface.aspx
 */

Yii::import('application.modules.robokassa.RobokassaModule');

/**
 * Class RobokassaPaymentSystem
 */
class RobokassaPaymentSystem extends PaymentSystem
{
    /**
     * @param Payment $payment
     * @param Order $order
     * @param bool|false $return
     * @return mixed|string
     */
    public function renderCheckoutForm(Payment $payment, Order $order, $return = false)
    {
        return Yii::app()->getController()->renderPartial(
            'application.modules.robokassa.views.form',
            [
                'id' => $order->id,
                'price' => Yii::app()->money->convert($order->getTotalPrice(), $payment->currency_id),
                'settings' => $payment->getPaymentSystemSettings(),
            ],
            $return
        );
    }

    /**
     * @param Payment $payment
     * @param CHttpRequest $request
     * @return bool
     */
    public function processCheckout(Payment $payment, CHttpRequest $request)
    {
        $amount = $request->getParam('OutSum');
        $orderId = (int)$request->getParam('InvId');
        $crc = strtoupper($request->getParam('SignatureValue'));

        $order = Order::model()->findByPk($orderId);

        if (null === $order) {
            Yii::log(
                Yii::t('RobokassaModule.robokassa', 'Order with id = {id} not found!', ['{id}' => $orderId]),
                CLogger::LEVEL_ERROR,
                self::LOG_CATEGORY
            );

            return false;
        }

        if ($order->isPaid()) {
            Yii::log(
                Yii::t('RobokassaModule.robokassa', 'Order with id = {id} already payed!', ['{id}' => $orderId]),
                CLogger::LEVEL_ERROR,
                self::LOG_CATEGORY
            );

            return false;
        }

        $settings = $payment->getPaymentSystemSettings();

        $myCrc = strtoupper(md5("$amount:$orderId:".$settings['password2']));

        if ($myCrc !== $crc) {
            Yii::log(
                Yii::t('RobokassaModule.robokassa', 'Error pay order with id = {id}! Bad crc!', ['{id}' => $orderId]),
                CLogger::LEVEL_ERROR,
                self::LOG_CATEGORY
            );

            return false;
        }

        if ($amount != Yii::app()->money->convert($order->total_price, $payment->currency_id)) {
            Yii::log(
                Yii::t(
                    'RobokassaModule.robokassa',
                    'Error pay order with id = {id}! Incorrect price!',
                    ['{id}' => $orderId]
                ),
                CLogger::LEVEL_ERROR,
                self::LOG_CATEGORY
            );

            return false;
        }

        if ($order->pay($payment)) {
            Yii::log(
                Yii::t('RobokassaModule.robokassa', 'Success pay order with id = {id}!', ['{id}' => $orderId]),
                CLogger::LEVEL_INFO,
                self::LOG_CATEGORY
            );

            return true;
        } else {
            Yii::log(
                Yii::t(
                    'RobokassaModule.robokassa',
                    'Error pay order with id = {id}! Error change status!',
                    ['{id}' => $orderId]
                ),
                CLogger::LEVEL_ERROR,
                self::LOG_CATEGORY
            );

            return false;
        }
    }
}
