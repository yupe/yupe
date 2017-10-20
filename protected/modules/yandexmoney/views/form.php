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
<?= CHtml::hiddenField('customerNumber', !empty($order->user_id)? $order->user_id : $order->email) ?>
<?= CHtml::hiddenField('paymentType', $settings['type']) ?>
<?= CHtml::hiddenField('orderNumber', $order->id) ?>
<?= CHtml::hiddenField('cps_phone', CHtml::encode($order->phone)) ?>
<?= CHtml::hiddenField('cps_email', CHtml::encode($order->email)) ?>
<?= CHtml::hiddenField('shopSuccessURL', Yii::app()->createAbsoluteUrl('/order/order/view', ['url' => $order->url])) ?>
<?= CHtml::hiddenField('shopFailURL', Yii::app()->createAbsoluteUrl('/order/order/view', ['url' => $order->url])) ?>
<?= $settings['ym_merchant_receipt'] ? CHtml::hiddenField('ym_merchant_receipt', json_encode($ym_merchant_receipt, JSON_UNESCAPED_UNICODE)): '' ?>
<?= CHtml::submitButton(Yii::t('YandexMoneyModule.ymoney', 'Pay')) ?>
<?= CHtml::endForm() ?>
