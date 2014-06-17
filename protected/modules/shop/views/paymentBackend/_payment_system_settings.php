<?php
/* @var $paymentManager PaymentManager */
/* @var $paymentSettings Array */
/* @var $paymentSystem string */
/* @var $model Payment */

if (!$paymentManager)
{
    $paymentManager = new PaymentManager();
}
if ($model)
{
    $paymentSystem   = $paymentSystem ? : $model->module;
    $paymentSettings = $paymentSettings ? : $model->getPaymentSystemSettings();
}
?>
<?php $paymentManager->renderSettings($paymentSystem, $paymentSettings); ?>