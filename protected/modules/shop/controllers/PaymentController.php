<?php

class PaymentController extends yupe\components\controllers\FrontController
{
    public function actionProcess($id = null)
    {
        $payment = Payment::model()->findByPk($id);
        if ($payment->module)
        {
            $paymentManager = new PaymentManager();
            $paymentSystem  = $paymentManager->loadPaymentSystemObject($payment->module);
            if ($paymentSystem)
            {
                $paymentSystem->processCheckout($payment);
            }
        }
    }
}
