<?php
/**
 * @var string $action Form action url
 * @var string $sessionId
 */
?>

<?= CHtml::beginForm($action) ?>
<?= CHtml::hiddenField('session_id', $sessionId) ?>
<?= CHtml::submitButton(Yii::t('PaylerModule.payler', 'Pay')) ?>
<?= CHtml::endForm() ?>
