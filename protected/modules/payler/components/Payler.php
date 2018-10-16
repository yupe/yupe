<?php

/**
 * Class for working with Payler API
 *
 * @package  yupe.modules.payler.components
 * @author   Oleg Filimonov <olegsabian@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     https://github.com/sabian/yupe-payler
 **/
class Payler
{
    // Payment key
    private $key;

    // Payment mode (secure or sandbox)
    private $mode;

    // Payment type
    private $type = 'OneStep';

    public function __construct(Payment $payment)
    {
        $settings = $payment->getPaymentSystemSettings();

        $this->key = $settings['key'];
        $this->mode = $settings['paymode'];
    }

    /**
     * Generate url
     *
     * @param string $method Payler API method
     * @return string
     * @link http://payler.com/docs/acquiring_docs
     */
    public function getUrl($method)
    {
        return 'https://' . $this->mode . '.payler.com/gapi/' . $method;
    }

    /**
     * Starts a payment session and returns its ID
     *
     * @param Order $order
     * @return string|bool
     */
    public function getSessionId(Order $order)
    {
        $data = [
            'key' => $this->key,
            'type' => $this->type,
            'order_id' => $order->url . '_' . time(),
            'amount' => $order->getTotalPriceWithDelivery() * 100,
            'product' => Yii::t('PaylerModule.payler', 'Order #{n}', $order->id)
        ];

        $sessionData = $this->sendRequest($data, 'StartSession');

        if (!isset($sessionData['session_id'])) {
            Yii::log(Yii::t('PaylerModule.payler', 'Session ID is not defined.'), CLogger::LEVEL_ERROR);

            return false;
        }

        return $sessionData['session_id'];
    }

    /**
     * Gets the order ID from hash
     *
     * @param CHttpRequest $request
     * @return string|bool
     */
    public function getOrderIdFromHash(CHttpRequest $request)
    {
        $orderHash = explode('_', $request->getParam('order_id'));

        if (count($orderHash) !== 2) {
            return false;
        }

        return $orderHash[0];
    }

    /**
     * Gets the status of the current payment
     *
     * @param CHttpRequest $request
     * @return string|bool
     */
    public function getPaymentStatus(CHttpRequest $request)
    {
        $data = [
            'key' => $this->key,
            'order_id' => $request->getParam('order_id'),
        ];

        $response = $this->sendRequest($data, 'GetStatus');

        if (!isset($response['status'])) {
            return false;
        }

        return $response['status'];
    }

    /**
     * Sends a request to the server
     *
     * @param array $data API method parameters
     * @param string $method Payler API method
     * @return bool|mixed
     */
    private function sendRequest($data, $method)
    {
        $data = http_build_query($data, '', '&');

        $options = [
            CURLOPT_URL => $this->getUrl($method),
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 45,
            CURLOPT_VERBOSE => false,
            CURLOPT_HTTPHEADER => [
                'Content-type: application/x-www-form-urlencoded',
                'Cache-Control: no-cache',
                'charset="utf-8"',
            ],
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $json = curl_exec($ch);
        if ($json === false) {
            Yii::log(Yii::t('PaylerModule.payler', 'Request error: {message}',
                ['{message}' => curl_error($ch)]), CLogger::LEVEL_ERROR);

            return false;
        }
        $result = json_decode($json, true);
        curl_close($ch);

        return $result;
    }
}