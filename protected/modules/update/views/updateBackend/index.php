<?php
$this->breadcrumbs = [
    Yii::t('UpdateModule.update', 'Modules') => ['/yupe/backend/settings'],
    Yii::t('UpdateModule.update', 'Check for update'),
];
?>

<h1><?php echo Yii::t('UpdateModule.update', 'Updates'); ?></h1>

<?php if ($success && count($updates)): ?>
    <div class=" alert alert-info" role="alert">
        <?= Yii::t('UpdateModule.update', 'Before upgrading, please backup your site and database!'); ?>
    </div>
    <div class="alert alert-warning" role="alert">
        <?= Yii::t('UpdateModule.update', 'Available updates: total !', ['total' => count($updates)]); ?>
    </div>
<?php elseif ($success): ?>
    <div class="alert alert-success" role="alert">
        <?= Yii::t('UpdateModule.update', 'You have the most current version'); ?>
    </div>
<?php endif; ?>

<?php if (false === $updates): ?>

    <div class="alert alert-danger">
        <?php echo Yii::t(
            'UpdateModule.update',
            'The error occurred. Failed to receive information about updates. Try later.'
        ); ?>
    </div>

<?php endif; ?>

<table class="table table-striped">
    <thead>
    <tr>
        <th style="width: 32px;"><?php echo Yii::t('UpdateModule.update', 'Module'); ?></th>
        <th style="width: 32px;"><?php echo Yii::t('UpdateModule.update', 'Description'); ?></th>
        <th style="width: 32px;"><?php echo Yii::t('UpdateModule.update', 'Developer'); ?></th>
        <th style="width: 32px;"><?php echo Yii::t('UpdateModule.update', 'Current version'); ?></th>
        <th style="width: 32px;"><?php echo Yii::t('UpdateModule.update', 'Available version'); ?></th>
        <th style="width: 32px"></th>
        <th style="width: 32px"></th>
    </tr>

    </thead>
    <tbody>
    <?php foreach ($modules as $id => $module): ?>
        <tr>
            <td><?php echo CHtml::encode($module->getName()); ?></td>
            <td>
                <?php echo CHtml::encode($module->getDescription()); ?>
            </td>
            <td>
                <?php echo CHtml::encode($module->getAuthor()); ?>
            </td>
            <td>
                <span class="label label-info"><?php echo CHtml::encode($module->getVersion()); ?></span>
            </td>
            <td>

                    <span
                        class="<?php echo isset($updates[$module->getId(
                        )]) ? 'label label-success' : 'label label-info'; ?>"><?php echo CHtml::encode(
                            isset($updates[$module->getId()]) ? $updates[$module->getId(
                            )]['version'] : $module->getVersion()
                        ); ?></span>
            </td>
            <td>
                <?php if (isset($updates[$module->getId()])): ?>
                    <?php echo CHtml::link(
                        Yii::t('UpdateModule.update', 'Whats new ?'),
                        '#',
                        ['class' => 'change-log', 'data-content' => $updates[$module->getId()]['change']]
                    ); ?>
                <?php endif; ?>
            </td>
            <td>
                <?php if (isset($updates[$module->getId()])): ?>
                    <a href="#" class="module-update"
                       data-version="<?= CHtml::encode($updates[$module->getId()]['version']); ?>"
                       data-module="<?= CHtml::encode($module->getId()); ?>"
                       title="<?= Yii::t('UpdateModule.update', 'update'); ?>"><span
                            class="fa fa-fw fa-download"></span></a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        $('.change-log').on('click', function (event) {
            event.preventDefault();
            $('#change-data-id').html($(this).attr('data-content'));
            $('#change-log-popup').modal('show');
        })

        $('a.module-update').on('click', function (event) {
            var $this = $(this);
            event.preventDefault();
            if (!window.confirm('<?= Yii::t('UpdateModule.update', 'Confirm updates ?');?>')) {
                return false;
            }

            $('#wait-for-update').modal('show');
            $.post('<?= Yii::app()->createUrl("/update/updateBackend/update");?>', {
                'module' : $this.data('module'),
                'version' : $this.data('version'),
                '<?= Yii::app()->getRequest()->csrfTokenName;?>': '<?= Yii::app()->getRequest()->csrfToken;?>'
            }, function(response){
                if(response.result) {
                    $('#wait-for-update').modal('hide');
                    window.location.reload();
                }else{
                    $('#notifications').notify({ message: { text: '<?= Yii::t('UpdateModule.update', 'The error occurred. Failed to receive information about updates. Try later.');?>' }, 'type': 'danger' }).show();
                    $('#wait-for-update').modal('hide');
                }
            }, 'json');
        });
    });
</script>


<?php $this->beginWidget(
    'bootstrap.widgets.TbModal',
    ['id' => 'change-log-popup']
); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><?php echo Yii::t('UpdateModule.update', 'Changes'); ?></h4>
</div>

<div class="modal-body" id="change-data-id">


</div>

<div class="modal-footer">
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'label' => Yii::t('UpdateModule.update', 'Close'),
            'url' => '#',
            'htmlOptions' => ['data-dismiss' => 'modal'],
        ]
    ); ?>
</div>

<?php $this->endWidget(); ?>

<?php $this->beginWidget(
    'bootstrap.widgets.TbModal',
    ['id' => 'wait-for-update']
); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><?php echo Yii::t('UpdateModule.update', 'Module update. Please, wait...'); ?></h4>
</div>

<div class="modal-body">

    <div class="progress progress-striped active">
        <div class="progress-bar" role="progressbar" style="width: 100%"></div>
    </div>

</div>

<?php $this->endWidget(); ?>


<script type="text/javascript">
    $(document).ajaxError(function () {
        $('#wait-for-update').modal('hide');
        $('#notifications').notify({ message: { text: '<?= Yii::t('UpdateModule.update', 'The error occurred. Failed to receive information about updates. Try later.');?>' }, 'type': 'danger' }).show();
    });
</script>

