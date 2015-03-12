<?php

/**
 * Class StripePaymentSystem
 */
Yii::import('application.modules.stripe.StripeModule');

class StripePaymentSystem extends PaymentSystem
{
    public function renderCheckoutForm(Payment $payment, Order $order, $return = false)
    {

        $totalPrice = (int)($order->getTotalPriceWithDelivery() * 100);
        $settings = $payment->getPaymentSystemSettings();
        $testMode = $settings['testmode'];

        if($testMode){
            $publicKey = $settings['public_key_test'];
        } else {
            $publicKey = $settings['public_key_live'];
        }

        $processUrl = Yii::app()->createAbsoluteUrl('/payment/payment/process', ['id' => $payment->id, 'success' => 'true']);

        $siteName = Yii::app()->getModule('yupe')->name;
        $mainAssets = Yii::app()->getAssetManager()->publish(
            Yii::getPathOfAlias('application.modules.yupe.views.assets.img')
        );
        $mainImage = $mainAssets . '/logo.png';
        $form = <<<HTML
        <form id="stripe-form" action="">
<script src="https://checkout.stripe.com/checkout.js"></script>
        <script>
        var handler = StripeCheckout.configure({
            key: '$publicKey',
            image: '$mainImage',
            token: function(token) {
            $.ajax({
                url: "$processUrl",
                type: "GET",
                data: {token: token, orderID: $order->id},
                success: function(msg){
                    if(msg == 'paid'){
                        location.reload();
                    }
                }
            });
            }
        });

        $(function(){

        $("#stripe-form").on('submit', function(e) {
            // Open Checkout with further options
            handler.open({
                name: '$siteName',
                description: 'Оплата заказа №$order->id',
                currency: "rub",
                amount: $totalPrice
            });
            e.preventDefault();
            return false;
        });

        // Close Checkout on page navigation
        $(window).on('popstate', function() {
            handler.close();
        });
        });
    </script>
    </form>
HTML;

        if ($return) {
            return $form;
        } else {
            echo $form;
        }
        return true;
    }

    public function processCheckout(Payment $payment, CHttpRequest $request)
    {
        $settings = $payment->getPaymentSystemSettings();
        $testMode = $settings['testmode'];

        if($testMode){
            $secretKey = $settings['secret_key_test'];
        } else {
            $secretKey = $settings['secret_key_live'];
        }
        Stripe::setApiKey($secretKey);

        $cardToken = \Yii::app()->request->getParam('token');
        $orderID = \Yii::app()->request->getParam('orderID');

        /**
         * @var Order $order
         */
        $order = Order::model()->findByAttributes(array('paypal_id' => $cardToken['id']));
        if (!$order) {
            $order = Order::model()->findByPk($orderID, 'user_id = ' . Yii::app()->getUser()->getId());
            $order->paypal_id = $cardToken['id'];
            $order->save();
        }
        $orderId = $order->id;
        $charge = null;
        try {
            $charge = Stripe_Charge::create(array(
                    "amount" => $order->getTotalPriceWithDelivery() * 100,
                    "currency" => "rub",
                    "card" => $cardToken['id'],
                    "description" => "Оплата заказа №" . $order->id
                )
            );
        } catch (Stripe_CardError $e) {
            // The card has been declined
        }
        if (null === $order) {
            Yii::log(Yii::t('StripeModule.stripe', 'Order with id = {id} not found!', ['{id}' => $orderId]),
                CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
//            return false;
        }

        if ($order->isPaid()) {
            Yii::log(Yii::t('StripeModule.stripe', 'Order with id = {id} already payed!', ['{id}' => $orderId]),
                CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
//            return false;
        }
        if ($charge && $charge->paid) {
            if ($order->pay($payment)) {
                Yii::log(Yii::t('StripeModule.stripe', 'Success pay order with id = {id}!', ['{id}' => $orderId]),
                    CLogger::LEVEL_INFO, self::LOG_CATEGORY);
                if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                    echo "paid";
                    exit;
                }
            } else {
                Yii::log(Yii::t('PayPalModule.stripe', 'Error pay order with id = {id}! Error change status!',
                    ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
            }
        } else {
            Yii::log(Yii::t('PayPalModule.stripe', 'Error pay order with id = {id}! Payment wasn\'t approved!',
                ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
        }
        Yii::app()->controller->redirect(Yii::app()->createUrl("/order/" . $order->url));
    }
}
