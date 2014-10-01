<?php
$this->breadcrumbs = array(
    Yii::t('UpdateModule.update', 'Modules') => array('/yupe/backend/settings'),
    Yii::t('UpdateModule.update', 'Check for update'),
);
?>

<h1><?php echo Yii::t('UpdateModule.update', 'Updates'); ?></h1>

<div id="result"></div>

<?php $this->beginWidget(
    'booster.widgets.TbModal',
    array('id' => 'check-for-update-modal')
); ?>

<div class="modal-header">
    <h4><?php echo Yii::t('UpdateModule.update', 'Check the updates, please wait...'); ?></h4>
</div>


<div class="modal-body">

    <div class="progress progress-striped active">
        <div class="progress-bar" role="progressbar" style="width: 100%"></div>
    </div>

</div>

<div class="modal-footer">

</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#check-for-update-modal').modal('show');
        $.post('<?php echo Yii::app()->createUrl('/update/updateBackend/index')?>', {'<?= Yii::app()->getRequest()->csrfTokenName;?>': '<?= Yii::app()->getRequest()->csrfToken;?>'}, function (response) {
            if (response.result) {
                $('#result').html(response.data);
                $('#check-for-update-modal').modal('hide');
            } else {
                $('#notifications').notify({ message: { text: response.data.message }, 'type': 'danger' }).show();
            }
        });
    });
    $(document).ajaxError(function(){
        $('#check-for-update-modal').modal('hide');
        $('#wait-for-update').modal('hide');
        $('#notifications').notify({ message: { text: '<?= Yii::t('UpdateModule.update', 'The error occurred. Failed to receive information about updates. Try later.');?>' }, 'type': 'danger' }).show();
    });
</script>

