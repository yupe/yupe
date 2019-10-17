<?php
/**
 * @var array $settings
 * @var Order $order
 */
?>
<?= CHtml::form(Yii::app()->createUrl('/tinkoffpay/payment/init', ['orderId' => $order->id]), 'get') ?>
<?= CHtml::endForm() ?>
