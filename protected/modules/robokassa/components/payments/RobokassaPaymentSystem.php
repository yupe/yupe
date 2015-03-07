<?php

/**
 * Class RobokassaPaymentSystem
 * @link http://www.robokassa.ru/ru/Doc/Ru/Interface.aspx
 */

Yii::import('application.modules.robokassa.RobokassaModule');

class RobokassaPaymentSystem extends PaymentSystem
{
    public function renderCheckoutForm(Payment $payment, Order $order, $return = false)
    {
        $settings = $payment->getPaymentSystemSettings();

        $mrhLogin = $settings['login'];
        $mrhPass1 = $settings['password1'];
        $culture = $settings['language'];

        $invId = $order->id;

        $invDesc = Yii::t('RobokassaModule.robokassa', 'Payment order #{id} on "{site}" website', ['{id}' => $order->id, '{site}' => Yii::app()->getModule('yupe')->siteName]);

        $outSum = Yii::app()->money->convert($order->getTotalPrice(), $payment->currency_id);

        $crc = md5("$mrhLogin:$outSum:$invId:$mrhPass1");

        $form = CHtml::form($settings['testmode'] ? "http://test.robokassa.ru/Index.aspx" : "https://merchant.roboxchange.com/Index.aspx");
        $form .= CHtml::hiddenField('MrchLogin', $mrhLogin);
        $form .= CHtml::hiddenField('OutSum', $outSum);
        $form .= CHtml::hiddenField('InvId', $invId);
        $form .= CHtml::hiddenField('Desc', $invDesc);
        $form .= CHtml::hiddenField('SignatureValue', $crc);
        $form .= CHtml::hiddenField('Culture', $culture);
        $form .= CHtml::submitButton(Yii::t('RobokassaModule.robokassa','Pay'));
        $form .= CHtml::endForm();

        if ($return) {
            return $form;
        } else {
            echo $form;
        }
    }

    public function processCheckout(Payment $payment, CHttpRequest $request)
    {
        $amount = $request->getParam('OutSum');
        $orderId = (int)$request->getParam('InvId');
        $crc = strtoupper($request->getParam('SignatureValue'));

        $order = Order::model()->findByPk($orderId);

        if (null === $order) {
            Yii::log(Yii::t('RobokassaModule.robokassa', 'Order with id = {id} not found!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
            return false;
        }

        if ($order->isPaid()) {
            Yii::log(Yii::t('RobokassaModule.robokassa', 'Order with id = {id} already payed!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
            return false;
        }

        $settings = $payment->getPaymentSystemSettings();

        $myCrc = strtoupper(md5("$amount:$orderId:" . $settings['password2']));

        if ($myCrc !== $crc) {
            Yii::log(Yii::t('RobokassaModule.robokassa', 'Error pay order with id = {id}! Bad crc!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
            return false;
        }

        if ($amount != Yii::app()->money->convert($order->total_price, $payment->currency_id)) {
            Yii::log(Yii::t('RobokassaModule.robokassa', 'Error pay order with id = {id}! Incorrect price!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
            return false;
        }

        if ($order->pay($payment)) {
            Yii::log(Yii::t('RobokassaModule.robokassa', 'Success pay order with id = {id}!', ['{id}' => $orderId]), CLogger::LEVEL_INFO, self::LOG_CATEGORY);
            return true;
        } else {
            Yii::log(Yii::t('RobokassaModule.robokassa', 'Error pay order with id = {id}! Error change status!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
            return false;
        }
    }
}
