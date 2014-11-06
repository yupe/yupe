<?php

/**
 * Class RobokassaPaymentSystem
 * @link http://www.robokassa.ru/ru/Doc/Ru/Interface.aspx
 */
class RobokassaPaymentSystem extends PaymentSystem
{
    public function renderCheckoutForm(Payment $payment, Order $order, $return = false)
    {
        $settings = $payment->getPaymentSystemSettings();

        $mrh_login = $settings['login'];
        $mrh_pass1 = $settings['password1'];

        $inv_id = $order->id;

        $inv_desc = "Оплата заказа №" . $order->id . ' в ' . Yii::app()->getModule('yupe')->siteName;

        $out_sum = Yii::app()->money->convert($order->total_price, $payment->currency_id);
        $in_curr = "PCR";
        $culture = $settings['language'];
        $crc = md5("$mrh_login:$out_sum:$inv_id:$mrh_pass1");

        $form = CHtml::form($settings['testmode'] ? "http://test.robokassa.ru/Index.aspx" : "https://merchant.roboxchange.com/Index.aspx");
        $form .= CHtml::hiddenField('MrchLogin', $mrh_login);
        $form .= CHtml::hiddenField('OutSum', $out_sum);
        $form .= CHtml::hiddenField('InvId', $inv_id);
        $form .= CHtml::hiddenField('Desc', $inv_desc);
        $form .= CHtml::hiddenField('SignatureValue', $crc);
        $form .= CHtml::hiddenField('IncCurrLabel', $in_curr);
        $form .= CHtml::hiddenField('Culture', $culture);
        $form .= CHtml::submitButton('Заплатить');
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
            Yii::log(Yii::t('PaymentModule.payment','Order with id = {id} not found!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
            return false;
        }

        if ($order->isPaid()) {
            Yii::log(Yii::t('PaymentModule.payment','Order with id = {id} already payed!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
            return false;
        }

        $settings = $payment->getPaymentSystemSettings();

        $myCrc = strtoupper(md5("$amount:$orderId:".$settings['password2']));

        if ($myCrc !== $crc) {
            Yii::log(Yii::t('PaymentModule.payment','Error pay order with id = {id}! Bad crc!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
            return false;
        }

        if ($amount != Yii::app()->money->convert($order->total_price, $payment->currency_id)) {
            Yii::log(Yii::t('PaymentModule.payment','Error pay order with id = {id}! Incorrect price!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
            return false;
        }

        if($order->pay($payment)) {
            //@TODO заменить на события
            Yii::log(Yii::t('PaymentModule.payment','Success pay order with id = {id}!', ['{id}' => $orderId]), CLogger::LEVEL_INFO, self::LOG_CATEGORY);
            $order->close();
            return true;
        }else{
            Yii::log(Yii::t('PaymentModule.payment','Error pay order with id = {id}! Error change status!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
            return false;
        }
    }
}
