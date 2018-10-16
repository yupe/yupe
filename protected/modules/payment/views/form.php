<?= CHtml::form(['/payment/payment/process', 'id' => $payment->id]);?>
<?= CHtml::hiddenField('order', $order->id); ?>
<?= CHtml::endForm() ?>