<?php

use yupe\components\controllers\FrontController;

class PaymentController extends FrontController
{
    public function actionProcess($id = null)
    {
        /* @var $payment Payment */
        $payment = Payment::model()->findByPk($id);
        if ($payment && $payment->module) {
            $paymentSystem = Yii::app()->paymentManager->getPaymentSystemObject($payment->module);
            if ($paymentSystem) {
                $paymentSystem->processCheckout($payment);
            }
        }
    }
}
