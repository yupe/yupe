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

    public function processCheckout(Payment $payment)
    {
        $amount = $_POST['OutSum'];
        $order_id = intval($_POST['InvId']);
        $crc = strtoupper($_POST['SignatureValue']);

        $order = Order::model()->findByPk($order_id);
        if (!$order) {
            die('Оплачиваемый заказ не найден.');
        }

        if ($order->paid) {
            die('Этот заказ уже оплачен.');
        }

        $settings = $payment->getPaymentSystemSettings();

        $mrh_pass2 = $settings['password2'];

        $my_crc = strtoupper(md5("$amount:$order_id:$mrh_pass2"));
        if ($my_crc !== $crc) {
            die("bad sign\n");
        }

        if ($amount != Yii::app()->money->convert($order->total_price, $payment->currency_id)) {
            die("incorrect price\n");
        }

        $order->paid = Order::PAID_STATUS_PAID;
        $order->payment_method_id = $payment->id;
        $order->save();
        $order->close();

        die("OK" . $order_id . "\n");
    }
}
