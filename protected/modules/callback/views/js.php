<script type="text/javascript">
    var yupeCallbackSendUrl = '<?= Yii::app()->createUrl('/callback/callback/send') ?>';
    var yupeCallbacPhonekMask = '<?=Yii::app()->getModule('callback')->phoneMask ?>';
    var yupeCallbackErrorMessage = '<div><?= Yii::t('CallbackModule.callback', 'Sorry, an error has occurred.') ?></div>';
</script>