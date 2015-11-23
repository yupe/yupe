<?php

/**
 * Class YandexMoneyPaymentSystem
 * @link https://money.yandex.ru/doc.xml?id=526537
 */

Yii::import('application.modules.yandexmoney.YandexMoneyModule');

/**
 * Class YandexMoneyPaymentSystem
 */
class YandexMoneyPaymentSystem extends PaymentSystem
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
            'application.modules.yandexmoney.views.form',
            [
                'settings' => $payment->getPaymentSystemSettings(),
                'order' => $order,
            ],
            $return
        );
    }

    /**
     * @param Payment $payment
     * @param CHttpRequest $request
     */
    public function processCheckout(Payment $payment, CHttpRequest $request)
    {
        $settings = $payment->getPaymentSystemSettings();

        $params = [
            'action' => $request->getParam('action'),
            'orderSumAmount' => $request->getParam('orderSumAmount'),
            'orderSumCurrencyPaycash' => $request->getParam('orderSumCurrencyPaycash'),
            'orderSumBankPaycash' => $request->getParam('orderSumBankPaycash'),
            'shopId' => $settings['shopid'],
            'invoiceId' => $request->getParam('invoiceId'),
            'customerNumber' => $request->getParam('customerNumber'),
            'password' => $settings['password'],
        ];

        /* @var $order Order */
        $order = Order::model()->findByPk($request->getParam('orderNumber'));

        if ($order === null) {
            $message = Yii::t('YandexMoneyModule.ymoney', 'The order doesn\'t exist.');
            Yii::log($message, CLogger::LEVEL_ERROR);

            $this->showResponse($params, $message, 200);
        }

        if ($order->isPaid()) {
            $message = Yii::t('YandexMoneyModule.ymoney', 'The order #{n} is already payed.', $order->getPrimaryKey());
            Yii::log($message, CLogger::LEVEL_ERROR);

            $this->showResponse($params, $message, 200);
        }

        if ($this->getOrderCheckSum($params) !== $request->getParam('md5')) {
            $message = Yii::t('YandexMoneyModule.ymoney', 'Wrong checksum');
            Yii::log($message, CLogger::LEVEL_ERROR);

            $this->showResponse($params, $message, 200);
        }

        if ((float)$order->getTotalPriceWithDelivery() !== (float)$params['orderSumAmount']) {
            $message = Yii::t('YandexMoneyModule.ymoney', 'Wrong payment amount');
            Yii::log($message, CLogger::LEVEL_ERROR);

            $this->showResponse($params, $message, 200);
        }

        if ($params['action'] === 'checkOrder') {
            $this->showResponse($params);
        }

        if ($params['action'] === 'paymentAviso' && $order->pay($payment)) {
            Yii::log(
                Yii::t(
                    'YandexMoneyModule.ymoney',
                    'The order #{n} has been payed successfully.',
                    $order->getPrimaryKey()
                ),
                CLogger::LEVEL_INFO
            );

            $this->showResponse($params);
        }
    }

    /**
     * @param array $params
     * @param string $message
     * @param int $code
     */
    private function showResponse(array $params, $message = '', $code = 0)
    {
        header("Content-type: text/xml; charset=utf-8");

        $writer = new XMLWriter;
        $writer->openURI('php://output');
        $writer->startDocument('1.0', 'UTF-8');

        $writer->startElement($params['action'].'Response');

        $writer->startAttribute('performedDatetime');
        $writer->text(date('c'));
        $writer->endAttribute();

        $writer->startAttribute('code');
        $writer->text($code);
        $writer->endAttribute();

        $writer->startAttribute('invoiceId');
        $writer->text($params['invoiceId']);
        $writer->endAttribute();

        $writer->startAttribute('message');
        $writer->text($message);
        $writer->endAttribute();

        $writer->startAttribute('shopId');
        $writer->text($params['shopId']);
        $writer->endAttribute();

        $writer->endElement();

        $writer->endDocument();

        Yii::app()->end();
    }

    /**
     * Generate order checksum
     *
     * @param array $params
     * @return string
     */
    private function getOrderCheckSum($params)
    {
        return strtoupper(
            md5(
                implode(';', $params)
            )
        );
    }
}
