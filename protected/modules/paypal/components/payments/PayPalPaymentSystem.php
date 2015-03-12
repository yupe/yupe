<?php

/**
 * Class RobokassaPaymentSystem
 * @link http://www.robokassa.ru/ru/Doc/Ru/Interface.aspx
 */

Yii::import('application.modules.paypal.PayPalModule');
Yii::import('vendor.paypal.rest-api-sdk-php.sample.common');
Yii::import('vendor.paypal.rest-api-sdk-php.sample.bootstrap');
require Yii::getPathOfAlias("vendor.paypal.rest-api-sdk-php.sample") . '/common.php';
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
//use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
class PayPalPaymentSystem extends PaymentSystem
{
    public function renderCheckoutForm(Payment $payment, Order $order, $return = false)
    {
        $settings = $payment->getPaymentSystemSettings();

        $clientId = $settings['clientId'];
        $clientSecret = $settings['clientSecret'];
        $testmode = $settings['testmode'];


        if($testmode){
            $clientId = 'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS';
            $clientSecret = 'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL';
        }

        $invId = $order->id;

        $apiContext = new ApiContext(new OAuthTokenCredential($clientId, $clientSecret));

        $apiContext->setConfig(
            array(
                'mode' => ($testmode) ? 'sandbox' : "live",
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => Yii::getPathOfAlias('application') . '/paypal.log',
                'log.LogLevel' => 'FINE',
                'validation.level' => 'log'
            )
        );

// ### Payer
// A resource representing a Payer that funds a payment
// For paypal account payments, set payment method
// to 'paypal'.
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

// ### Itemized information
// (Optional) Lets you specify item wise
// information
        $orderProducts = $order->getProducts();
        if($orderProducts){
            $itemListItems = array();
            $minusPrice = 0;
            foreach ($orderProducts as $key => $product) {
                if($product->price < 0){
                    $minusPrice += $product->price;
                    unset($orderProducts[$key]);
                }
            }
            foreach ($orderProducts as $key => $product) {
	            if(!$product->product_name)
		            continue;
                $item = new Item();
                $name = $title=trim(mb_substr($product->product_name,0,mb_strrpos(mb_substr($product->product_name,0,50,'utf-8'),' ','utf-8'),'utf-8'), '\,');
                $item->setName($name)
                    ->setCurrency('USD')
                    ->setQuantity($product->quantity)
                    ->setPrice($product->price + ($minusPrice / $product->quantity));
                $itemListItems[] = $item;
                $minusPrice = 0;
            }
            $itemList = new ItemList();
            if($itemListItems){
	            $itemList->setItems($itemListItems);
            }
        }

// ### Additional payment details
// Use this optional field to set additional
// payment information such as tax, shipping
// charges etc.
        $details = new Details();
        $details->setShipping($order->getDeliveryPrice())
            ->setTax(0)
            ->setSubtotal($order->getTotalPrice() + $order->discount + $order->getCouponDiscount($order->getValidCoupons($order->getCoupons())));
        $details->setShippingDiscount((-1) * ($order->discount + $order->getCouponDiscount($order->getValidCoupons($order->getCoupons()))));

// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($order->getTotalPriceWithDelivery())
            ->setDetails($details);
//        var_dump($amount, $details);exit;
// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it.
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription("Оплата заказа №" . $order->id)
            ->setInvoiceNumber(uniqid());

        if(isset($itemList) && $itemList->getItems()){
	        $transaction->setItemList($itemList);
        }

// ### Redirect urls
// Set the urls that the buyer must be redirected to after
// payment approval/ cancellation.
        $baseUrl = Yii::app()->createAbsoluteUrl("/");
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("$baseUrl/payment/process/2?success=true")
            ->setCancelUrl("$baseUrl/payment/process/2?success=false");

// ### Payment
// A Payment Resource; create one using
// the above types and intent set to 'sale'
        $paymentPayPal = new PayPal\Api\Payment();
        $paymentPayPal->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));


// For Sample Purposes Only.
//        $request = clone $paymentPayPal;

// ### Create Payment
// Create a payment by calling the 'create' method
// passing it a valid apiContext.
// (See bootstrap.php for more on `ApiContext`)
// The return object contains the state and the
// url to which the buyer must be redirected to
// for payment approval
        try {
            $paymentPayPal->create($apiContext);
        } catch (Exception $ex) {
            ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $paymentPayPal, $ex);
            exit(1);
        }

// ### Get redirect url
// The API response provides the url that you must redirect
// the buyer to. Retrieve the url from the $payment->getLinks()
// method
        foreach ($paymentPayPal->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $approvalUrl = $link->getHref();
                break;
            }
        }

        if(!$order->paypal_id){
        }
        $order->paypal_id = $paymentPayPal->id;
        $order->save();

        $parseUrl = parse_url($approvalUrl);
        $query = $parseUrl['query'];
        unset($parseUrl['query']);
        $formUrl = $parseUrl['scheme'] . "://" . $parseUrl['host'] . $parseUrl['path'];
        $queryArray = explode("&",$query);
        $querySubArray = array();
        if($queryArray){
            foreach ($queryArray as $subQuery) {
                $querySubArray[] = explode("=",$subQuery);
            }
        }

        $form = CHtml::form($formUrl,"GET", ['class' => 'paypal-form']);
        if($querySubArray){
            foreach ($querySubArray as $sub) {
                $form .= CHtml::hiddenField($sub[0], $sub[1]);
            }

        }
        $form .= CHtml::submitButton(Yii::t('PayPalModule.paypal',''),['class' => "paypal-pay"]);
        $form .= CHtml::endForm();

        if($return){
            return $form;
        } else {
            echo $form;
        }
        return true;
    }

    public function processCheckout(Payment $payment, CHttpRequest $request)
    {
        $paymentId = \Yii::app()->request->getParam('paymentId', "");

        /**
         * @var Order $order
         */
        $order = Order::model()->findByAttributes(array('paypal_id' => $paymentId));

        $settings = $payment->getPaymentSystemSettings();

        $clientId = $settings['clientId'];
        $clientSecret = $settings['clientSecret'];
        $testmode = $settings['testmode'];

        if($testmode){
            $clientId = 'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS';
            $clientSecret = 'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL';
        }

        $orderId = $order->id;

        $apiContext = new ApiContext(new OAuthTokenCredential($clientId, $clientSecret));

        $apiContext->setConfig(
            array(
                'mode' => ($testmode) ? 'sandbox' : "live",
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => Yii::getPathOfAlias('application') . '/paypal.log',
                'log.LogLevel' => 'FINE',
                'validation.level' => 'log'
            )
        );
        if($paymentId){
            $paymentPayPal = new PayPal\Api\Payment();
            $paymentPayPal->setId($paymentId);

            $payerId = Yii::app()->getRequest()->getParam('PayerID');
            $token = Yii::app()->getRequest()->getParam('token');
            $paymentExecution = new PaymentExecution();
            $paymentExecution->setPayerId($payerId);
            $info = $paymentPayPal->get($paymentId,$apiContext);
            if($info->getState() == 'created'){
                $info = $paymentPayPal->execute($paymentExecution,$apiContext);
            }
        }

        if (null === $order) {
            Yii::log(Yii::t('PayPalModule.paypal', 'Order with id = {id} not found!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
            return false;
        }

        if ($order->isPaid()) {
            Yii::log(Yii::t('PayPalModule.paypal', 'Order with id = {id} already payed!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
//            return false;
        }

        $settings = $payment->getPaymentSystemSettings();

        if($info->getState() == 'approved'){
            if ($order->pay($payment)) {
                Yii::log(Yii::t('PayPalModule.paypal', 'Success pay order with id = {id}!', ['{id}' => $orderId]), CLogger::LEVEL_INFO, self::LOG_CATEGORY);
//                return true;
            } else {
                Yii::log(Yii::t('PayPalModule.paypal', 'Error pay order with id = {id}! Error change status!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
//                return false;
            }
        } else {
            Yii::log(Yii::t('PayPalModule.paypal', 'Error pay order with id = {id}! Payment wasn\'t approved!', ['{id}' => $orderId]), CLogger::LEVEL_ERROR, self::LOG_CATEGORY);
//            return false;
        }
        Yii::app()->controller->redirect(Yii::app()->createUrl("/order/" . $order->url));
    }
}
