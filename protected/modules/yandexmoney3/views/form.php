<?php
/**
 * @var array $settings
 * @var Order $order
 */
?>
<?= CHtml::form( Yii::app()->createUrl('/yandexmoney3/payment/init'), 'get') ?>
<?= CHtml::hiddenField('order', $order->id); ?>
<?= CHtml::endForm() ?>
