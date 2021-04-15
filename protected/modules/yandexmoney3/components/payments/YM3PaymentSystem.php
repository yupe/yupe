<?php

/**
 * Class YM3PaymentSystem
 */

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

Yii::import('application.modules.yandexmoney3.YM3PayModule');


class YM3PaymentSystem extends PaymentSystem
{
    const ERROR_ORDER_NOT_FOUND = 0;
    const ERROR_PROCESS_PAYMENT = 1;

    protected $payment;

    public function init()
    {
        parent::init();

        /* @var $payment Payment */
        $this->payment = Payment::model()->findByAttributes(['module' => 'yandexmoney3']);
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
            'application.modules.yandexmoney3.views.form',
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
        $currency = Yii::app()->hasModule('store') ? Yii::app()->getModule('store')->currency : 'RUB';

        $data = [
            'amount' => [
                'value' => $order->getTotalPriceWithDelivery(),
                'currency' => $currency
            ],
            'capture' => true,
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => Yii::app()->createAbsoluteUrl('/order/order/view', ['url' => $order->url])
            ],
            'metadata' => [
                'order_id' => $order->id
            ],
            'description' => Yii::t('YM3PayModule.ymoney', 'Order payment in store «{n}»', Yii::app()->getModule('yupe')->siteName ),
        ];

        if ($settings['includeReceipt']) {
            $receipt = [];
            $receipt["email"] = $order->email;
            if ( !$order->email ) {
                $receipt["phone"] = $order->phone;
            }
            $receipt["tax_system_code"] = $settings['tax_system_code'];
            $receipt["items"] = [];
            foreach ($order->products as $position) {
                /** @var OrderProduct $position */
                $receipt["items"][] = [
                    'description' => $position->product_name,
                    'quantity' => (int)$position->quantity,
                    'amount' => [
                        'value' => $position->price,
                        'currency' => $currency
                    ],
                    'vat_code' => $settings['vat_code']
                ];
            }

            //Включаем доставку в позиции заказа
            if (!$order->separate_delivery && $order->delivery->price > 0) {
                $receipt["items"][] = [
                    'description' => Yii::t('YM3PayModule.ymoney', 'Delivery') . ": " . $order->delivery->name,
                    'quantity' => 1,
                    'amount' => [
                        'value' => $order->delivery->price,
                        'currency' => $currency
                    ],
                    'vat_code' => $settings['vat_code'],
                    'payment_subject' => 'service'
                ];
            }

            $data['receipt'] = $receipt;
        }

        return $data;
    }

    /**
     * @param Payment $payment
     * @param CHttpRequest $request
     * @param int $orderId
     */
    public function processCheckout(Payment $payment, CHttpRequest $request)
    {

        $postData = json_decode($request->getRawBody(), true);

        Yii::log($request->getRawBody());

        $settings = $payment->getPaymentSystemSettings();

        $params = [
            'action' => $request->getParam('action'),
            'status' => $postData['event'] ?? null,
            'orderId' => $postData['object']['metadata']['order_id'] ?? null,
            'orderSumAmount' => $postData['object']['amount']['value'] ?? null,
            'password' => $settings['password'],
        ];

        Yii::log(print_r($postData, true));
        Yii::log(print_r($params, true));

        if ( !($order = Order::model()->findByPk($params['orderId'])) ) {
            $message = Yii::t('YM3PayModule.ymoney', 'The order doesn\'t exist.');
            Yii::log($message, CLogger::LEVEL_ERROR);
            throw new Exception($message);
        }

        if (in_array($params['status'], ['refund.succeeded', 'payment.canceled']) && $order->isPaid() && $order->unpay($payment)) {
            $this->showResponse($params);
        }

        if (in_array($params['status'], ['payment.canceled'])) {
            $this->showResponse($params);
        }

        if ($order->isPaid()) {
            $message = Yii::t('YM3PayModule.ymoney', 'The order #{n} is already payed.', $order->getPrimaryKey());
            Yii::log($message, CLogger::LEVEL_ERROR);

            $this->showResponse($params, 'NOTOK', 200);
        }

        $orderSum = (int)($order->getTotalPriceWithDelivery() * 100);
        $orderSumByRequest = (int)($params['orderSumAmount'] * 100);
        if ( $orderSum !== $orderSumByRequest ) {
            $message = Yii::t('YM3PayModule.ymoney', 'Wrong payment amount'). " orderSum:$orderSum orderSumByRequest:$orderSumByRequest" ;
            Yii::log($message, CLogger::LEVEL_ERROR);

            $this->showResponse($params, 'NOTOK', 500);
        }

        if ( in_array($params['status'], ['payment.succeeded', 'payment.waiting_for_capture']) && $order->pay($payment)) {
            Yii::log(
                Yii::t(
                    'YM3PayModule.ymoney',
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
            $message = Yii::t('YM3PayModule.ymoney', 'The order doesn\'t exist.');
            Yii::log($message, CLogger::LEVEL_ERROR);
            throw new Exception($message, self::ERROR_ORDER_NOT_FOUND);
        }

        $this->payment = Payment::model()->findByAttributes(['module' => 'yandexmoney3']);

        if (!$this->payment instanceof Payment)
            throw new Exception('Создайте способ оплаты');

        $postData = $this->getPaymentPostData($this->payment, $order);

        $paymentSettings = $this->payment->getPaymentSystemSettings();

        Yii::log(json_encode($postData, JSON_UNESCAPED_UNICODE));
//        echo json_encode($postData);die;
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://payment.yandex.net/api/v3/payments', [
                \GuzzleHttp\RequestOptions::JSON => $postData,
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Idempotence-Key' => uniqid('ym3', true)
                ],
                \GuzzleHttp\RequestOptions::AUTH => [
                    $paymentSettings['shopId'], $paymentSettings['password']
                ]
            ]);

            $body = $response->getBody()->getContents();

            if (!empty($body)) {
                $body = json_decode($body, true);
                if ( empty($body['confirmation']) || empty($body['confirmation']['confirmation_url']) ) {
                    Yii::log('Ошибка оплаты. Подробности: ' . ($body['description'] ?? null) . json_encode($body, true), CLogger::LEVEL_ERROR);
                    throw new Exception('Ошибка оплаты', self::ERROR_PROCESS_PAYMENT);
                }
                Yii::app()->controller->redirect($body['confirmation']['confirmation_url']);
            }
        } catch (Exception $e) {
            Yii::log('Ошибка оплаты. Подробности: ' . $e->getMessage(), CLogger::LEVEL_ERROR);
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
