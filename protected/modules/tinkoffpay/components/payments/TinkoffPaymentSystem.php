<?php

/**
 * Class TinkoffPaymentSystem
 */

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

Yii::import('application.modules.tinkoffpay.TinkoffPayModule');

/**
 * Class TinkoffPaymentSystem
 */
class TinkoffPaymentSystem extends PaymentSystem
{
    const ERROR_ORDER_NOT_FOUND = 0;
    const ERROR_PROCESS_PAYMENT = 1;

    protected $payment;

    public function init()
    {
        parent::init();

        /* @var $payment Payment */
        $this->payment = Payment::model()->findByAttributes(['module' => 'tinkoffpay']);
    }

    /**
     * @param Payment $payment
     * @param Order $order
     * @param bool|false $return
     * @return mixed|string
     */
    public function renderCheckoutForm(Payment $payment, Order $order, $return = false)
    {
        return Yii::app()->getController()->renderPartial(
            'application.modules.tinkoffpay.views.form',
            [
                'order' => $order,
                'orderCheckUrl' => Yii::app()->createUrl('payment/payment/process', ['id' => $payment->id]),
            ],
            $return
        );
    }

    /**
     * @param Payment $payment
     * @param Order $order
     * @return mixed|string
     */
    public function getPaymentPostData(Payment $payment, Order $order)
    {
        $settings = $payment->getPaymentSystemSettings();

        $receipt = [];
        if ($settings['includeReceipt']) {
            $receipt["Email"] = $order->email;
            $receipt["Taxation"] = $settings['Taxation'];
            $receipt["Items"] = [];
            $arr = [];
            foreach ($order->products as $product) {
                /** @var Product $product */
                $arr["Name"] = $product->product_name;
                $arr["Quantity"] = (int)$product->quantity;
                $arr["Price"] = $product->price * 100;
                $arr["Amount"] = ($product->price * 100) * $product->quantity;
                $arr["Tax"] = $settings['Tax'];
                $receipt["Items"][] = $arr;
            }

            //Включаем доставку в позиции заказа
            if ($order->delivery->price > 0) {
                $arr["Name"] = Yii::t('TinkoffPayModule.tpay', 'Delivery') . ": " . $order->delivery->name;
                $arr["Quantity"] = 1; // доставка всегда одна штука в заказе
                $arr["Price"] = $order->delivery->price * 100;
                $arr["Amount"] = $order->delivery->price * 100;
                $arr["Tax"] = $settings['Tax'];
                $arr["PaymentObject"] = 'service';
                $receipt["Items"][] = $arr;
            }
        }

        $data = [
            'TerminalKey' => $settings['TerminalKey'],
            'Amount' => $order->getTotalPriceWithDelivery() * 100,
            'OrderId' => $order->id,
            'SuccessURL' => Yii::app()->createAbsoluteUrl('/order/order/view', ['url' => $order->url]),
            'NotificationURL' => Yii::app()->createAbsoluteUrl('payment/payment/process', ['id' => $payment->id]),
            'PayType' => 'О',
            'Description' => Yii::t('TinkoffPayModule.tpay', 'Order payment in store «{n}»', Yii::app()->getModule('yupe')->siteName ),
        ];

        if ($settings['includeReceipt'])
            $data['Receipt'] = $receipt;

        return $data;
    }

    /**
     * @param Payment $payment
     * @param CHttpRequest $request
     * @param int $orderId
     */
    public function processCheckout(Payment $payment, CHttpRequest $request)
    {

        $postData = json_decode($request->getRawBody(), JSON_UNESCAPED_UNICODE);

        Yii::log($request->getRawBody());

        $settings = $payment->getPaymentSystemSettings();

        $params = [
            'action' => $request->getParam('action'),
            'status' => $postData['Status'] ?? null,
            'orderId' => $postData['OrderId'] ?? null,
            'orderSumAmount' => $postData['Amount'] ?? null,
            'password' => $settings['Password'],
        ];


        if (in_array($params['status'], ['REJECTED', 'REVERSED']))
            $this->showResponse($params);

        /* @var $order Order */
        $order = Order::model()->findByPk($params['orderId']);

        if ($order === null) {
            $message = Yii::t('TinkoffPayModule.tpay', 'The order doesn\'t exist.');
            Yii::log($message, CLogger::LEVEL_ERROR);
            throw new Exception($message);
        }

        if (in_array($params['status'], ['PARTIAL_REFUNDED', 'REFUNDED']) && $order->unpay($payment))
            $this->showResponse($params);

        if ($order->isPaid()) {
            $message = Yii::t('TinkoffPayModule.tpay', 'The order #{n} is already payed.', $order->getPrimaryKey());
            Yii::log($message, CLogger::LEVEL_ERROR);

            $this->showResponse($params, 'NOTOK', 200);
        }

        $orderSum = (int)($order->getTotalPriceWithDelivery() * 100);
        $orderSumByRequest = (int)$params['orderSumAmount'];
        if ( $orderSum !== $orderSumByRequest ) {
            $message = Yii::t('TinkoffPayModule.tpay', 'Wrong payment amount'). " orderSum:$orderSum orderSumByRequest:$orderSumByRequest" ;
            Yii::log($message, CLogger::LEVEL_ERROR);

            $this->showResponse($params, 'NOTOK', 500);
        }

        if ($params['status'] === 'AUTHORIZED')
            $this->showResponse($params);

        if ($params['status'] === 'CONFIRMED' && $order->pay($payment)) {
            Yii::log(
                Yii::t(
                    'TinkoffPayModule.tpay',
                    'The order #{n} has been payed successfully.',
                    $order->getPrimaryKey()
                ),
                CLogger::LEVEL_INFO
            );

            $this->showResponse($params);
        }
    }

    /**
     * @param Payment $payment
     * @param CHttpRequest $request
     * @param int $orderId
     */
    public function processInit(CHttpRequest $request, Order $order)
    {
        if (!$order) {
            $message = Yii::t('TinkoffPayModule.tpay', 'The order doesn\'t exist.');
            Yii::log($message, CLogger::LEVEL_ERROR);
            throw new Exception($message, self::ERROR_ORDER_NOT_FOUND);
        }

        $this->payment = Payment::model()->findByAttributes(['module' => 'tinkoffpay']);

        if (!$this->payment instanceof Payment)
            throw new Exception('Создайте способ оплаты');

        $postData = $this->getPaymentPostData($this->payment, $order);

//        echo json_encode($postData);die;
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://securepay.tinkoff.ru/v2/Init', [
                \GuzzleHttp\RequestOptions::JSON => $postData,
            ]);


            $body = $response->getBody()->getContents();

            if (!empty($body)) {
                $body = json_decode($body, true);
                if (empty($body['PaymentURL']))
                    throw new Exception('Ошибка оплаты', self::ERROR_PROCESS_PAYMENT);
                Yii::app()->controller->redirect($body['PaymentURL']);
            }
        } catch (Exception $e) {
            throw new Exception('Ошибка оплаты', self::ERROR_PROCESS_PAYMENT);
        }
    }

    /**
     * @param array $params
     * @param string $message
     * @param int $code
     */
    private function showResponse(array $params, $message = 'OK', $code = 0)
    {
        echo $message;

        Yii::app()->end($code);
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
