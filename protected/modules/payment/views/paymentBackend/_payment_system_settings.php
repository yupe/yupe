<?php
/* @var $paymentSettings Array */
/* @var $paymentSystem string */

$paymentSystemObject = Yii::app()->paymentManager->getPaymentSystemObject($paymentSystem);
if ($paymentSystemObject) {
    $paymentSystemObject->renderSettings($paymentSettings);
}

