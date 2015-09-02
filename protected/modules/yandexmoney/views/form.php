<?php
/**
 * @var array $settings
 * @var Order $order
 */
?>

<?= CHtml::form('https://' . $settings['mode'] . '.yandex.ru/eshop.xml') ?>
<?= CHtml::hiddenField('shopId', $settings['shopid']) ?>
<?= CHtml::hiddenField('scid', $settings['scid']) ?>
<?= CHtml::hiddenField('sum', $order->getTotalPriceWithDelivery()) ?>
<?= CHtml::hiddenField('customerNumber', $order->user_id) ?>
<?= CHtml::hiddenField('paymentType', $settings['type']) ?>
<?= CHtml::hiddenField('orderNumber', $order->id) ?>
<?= CHtml::hiddenField('cps_phone', CHtml::encode($order->phone)) ?>
<?= CHtml::hiddenField('cps_email', CHtml::encode($order->email)) ?>
<?= CHtml::hiddenField('shopSuccessURL', Yii::app()->createAbsoluteUrl('/order/order/view', ['url' => $order->url])) ?>
<?= CHtml::hiddenField('shopFailURL', Yii::app()->createAbsoluteUrl('/order/order/view', ['url' => $order->url])) ?>
<?= CHtml::submitButton(Yii::t('YandexMoneyModule.ymoney', 'Pay')) ?>
<?= CHtml::endForm() ?>
