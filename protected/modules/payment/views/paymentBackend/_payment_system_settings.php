<?php
/* @var $paymentSettings Array */
/* @var $paymentSystem string */
/* @var $model Payment */

if ($model) {
    $paymentSystem = $paymentSystem ?: $model->module;
    $paymentSettings = $paymentSettings ?: $model->getPaymentSystemSettings();
}
?>
<?php $paymentSystemObject = Yii::app()->paymentManager->getPaymentSystemObject($paymentSystem); ?>
<?php if ($paymentSystemObject) {
    $paymentSystemObject->renderSettings($paymentSettings);
} ?>
