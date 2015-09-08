<?php
/**
 * @var string $action
 * @var integer $orderId
 */
?>

<?= CHtml::form($action) ?>
<?= CHtml::submitButton(Yii::t('ManualPayModule.manual','Pay')) ?>
<?= CHtml::hiddenField('orderId', $orderId) ?>
<?= CHtml::endForm() ?>
