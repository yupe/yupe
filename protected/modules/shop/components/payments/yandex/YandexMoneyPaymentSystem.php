<?php

/**
 * Class YandexMoneyPaymentSystem
 * @link https://money.yandex.ru/doc.xml?id=526537
 */
class YandexMoneyPaymentSystem implements IPaymentSystem
{

    public function renderCheckoutForm(Payment $payment, Order $order, $return = false)
    {
        $settings = $payment->getPaymentSystemSettings();

        $form = CHtml::form($settings['testmode'] ? "https://demomoney.yandex.ru/eshop.xml" : "https://money.yandex.ru/eshop.xml");
        $form .= CHtml::hiddenField('shopId', $settings['shopid']);
        $form .= CHtml::hiddenField('scid', $settings['scid']);
        $form .= CHtml::hiddenField('sum', round(Yii::app()->money->convert($order->total_price, $payment->currency_id), 2));
        $form .= CHtml::hiddenField('customerNumber', $order->user_id);
        $form .= CHtml::hiddenField('paymentType', $settings['paymenttype']);
        $form .= CHtml::hiddenField('orderNumber', $order->id);
        $form .= CHtml::hiddenField('cps_phone', htmlspecialchars($order->phone, ENT_QUOTES));
        $form .= CHtml::hiddenField('cps_email', htmlspecialchars($order->email, ENT_QUOTES));
        $form .= CHtml::hiddenField('shopSuccessURL', Yii::app()->createAbsoluteUrl('/shop/order/view', array('url' => $order->url)));
        $form .= CHtml::hiddenField('shopFailURL', Yii::app()->createAbsoluteUrl('/shop/order/view', array('url' => $order->url)));
        $form .= CHtml::submitButton('Заплатить');
        $form .= CHtml::endForm();

        if ($return)
        {
            return $form;
        }
        else
        {
            echo $form;
        }
    }

    public function processCheckout(Payment $payment)
    {
        $order_id   = $_POST['orderNumber'];
        $invoice_id = $_POST['invoiceId'];

        /* @var $order Order */
        $order = Order::model()->findByPk($order_id);
        if (!$order)
        {
            $this->printError('Оплачиваемый заказ не найден.');
        }
        $settings = $payment->getPaymentSystemSettings();
        $shop_id  = $settings['shopid'];
        if ($order->paid)
        {
            $this->printError('Этот заказ уже оплачен.');
        }

        $str = $_POST['action'] . ';'
            . $_POST['orderSumAmount'] . ';'
            . $_POST['orderSumCurrencyPaycash'] . ';'
            . $_POST['orderSumBankPaycash'] . ';'
            . $shop_id . ';'
            . $invoice_id . ';'
            . $_POST['customerNumber'] . ';'
            . $settings['password'];

        $md5 = strtoupper(md5($str));
        if ($md5 !== $_POST['md5'])
        {
            $this->printError("Контрольная подпись не верна.");
        }

        $order_amount = Yii::app()->money->convert($order->total_price, $payment->currency_id);

        if (floatval($order_amount) !== floatval($_POST['orderSumAmount']))
        {
            $this->printError("Неверная сумма оплаты");
        }

        if ($_POST['action'] == 'paymentAviso')
        {
            $order->paid              = Order::PAID_STATUS_PAID;
            $order->payment_method_id = $payment->id;
            $order->save();
            $order->close();

            $datetime          = new DateTime();
            $performedDatetime = $datetime->format('c');
            echo '<?xml version="1.0" encoding="UTF-8"?>
                 <paymentAvisoResponse performedDatetime="' . $performedDatetime . '"
                 code="0" invoiceId="' . $invoice_id . '"
                 shopId="' . $shop_id . '"/>';
        }
        elseif ($_POST['action'] == 'checkOrder')
        {
            $datetime          = new DateTime();
            $performedDatetime = $datetime->format('c');
            echo '<?xml version="1.0" encoding="UTF-8"?>
                 <checkOrderResponse performedDatetime="' . $performedDatetime . '"
                 code="0" invoiceId="' . $invoice_id . '"
                 shopId="' . $shop_id . '"/>';
        }
    }

    function printError($text)
    {
        $datetime          = new DateTime();
        $performedDatetime = $datetime->format('c');
        $shop_id           = intval($_POST['shopId']);
        $invoice_id        = intval($_POST['invoiceId']);

        $response = '';
        $action   = $_POST['action'];
        if ($action === 'paymentAviso')
        {
            $response = 'paymentAvisoResponse';
        }
        elseif ($action === 'checkOrder')
        {
            $response = 'checkOrderResponse';
        }

        echo '<?xml version="1.0" encoding="UTF-8"?>
        <' . $response . ' performedDatetime="' . $performedDatetime . '"
        code="200" invoiceId="' . $invoice_id . '"
        message="' . $text . '" shopId="' . $shop_id . '"/>';

        exit();
    }
}