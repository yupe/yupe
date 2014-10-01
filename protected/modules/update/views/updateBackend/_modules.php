    <?php if($total):?>
        <div class=" alert alert-info" role="alert">
            <?= Yii::t('UpdateModule.update', 'Before upgrading, please backup your site and database!');?>
        </div>
        <div class="alert alert-warning" role="alert">
            <?= Yii::t('UpdateModule.update', 'Available updates: total !', ['total' => $total]); ?>
        </div>
    <?php elseif($result):?>
        <div class="alert alert-success" role="alert">
            <?= Yii::t('UpdateModule.update', 'You have the most current version');?>
        </div>
    <?php endif;?>

    <?php if(!$result):?>

        <div class="alert alert-danger">
            <?php echo Yii::t('UpdateModule.update', 'The error occurred. Failed to receive information about updates. Try later.');?>
        </div>

    <?php endif;?>

    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width: 32px;"><?php echo Yii::t('UpdateModule.update', 'Module');?></th>
            <th style="width: 32px;"><?php echo Yii::t('UpdateModule.update', 'Description');?></th>
            <th style="width: 32px;"><?php echo Yii::t('UpdateModule.update', 'Developer');?></th>
            <th style="width: 32px;"><?php echo Yii::t('UpdateModule.update', 'Current version');?></th>
            <th style="width: 32px;"><?php echo Yii::t('UpdateModule.update', 'Available version');?></th>
            <th style="width: 32px"></th>
            <th style="width: 32px"></th>
        </tr>

        </thead>
        <tbody>
        <?php foreach ($modules as $id => $module): ?>
            <tr>
                <td><?php echo CHtml::encode($module['module']->getName()); ?></td>
                <td>
                    <?php echo CHtml::encode($module['module']->getDescription()); ?>
                </td>
                <td>
                    <?php echo CHtml::encode($module['module']->getAuthor()); ?>
                </td>
                <td>
                    <span class="label label-info"><?php echo CHtml::encode($module['module']->getVersion()); ?></span>
                </td>
                <td>
                    <span
                        class="<?php echo $module['update'] ? 'label label-success' : 'label label-info'; ?>"><?php echo CHtml::encode(
                            $module['version']
                        ); ?></span>
                </td>
                <td>
                    <?php if ($module['update']): ?>
                        <?php echo CHtml::link(
                            Yii::t('UpdateModule.update', 'Whats new ?'),
                            '#',
                            array('class' => 'change-log', 'data-content' => $module['change'])
                        ); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($module['update']):?>
                        <a href="#" class="module-update" data-version="<?= CHtml::encode($module['version']);?>"  data-module="<?= CHtml::encode($module['module']->getId());?>" title="<?= Yii::t('UpdateModule.update', 'update');?>"><span class="glyphicon glyphicon-download"></span></a>
                    <?php endif;?>
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

            $('a.module-update').on('click', function(event){
                var $this = $(this);
                event.preventDefault();
                if(!window.confirm('Подтвеждаете обновление ?')) {
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
                }, 'json')
            });
        });
    </script>


<?php $this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'change-log-popup')
); ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4><?php echo Yii::t('UpdateModule.update', 'Changes');?></h4>
    </div>

    <div class="modal-body" id="change-data-id">


    </div>

    <div class="modal-footer">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'label' => Yii::t('UpdateModule.update', 'Close'),
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>

<?php $this->endWidget(); ?>



    <?php $this->beginWidget(
        'bootstrap.widgets.TbModal',
        array('id' => 'wait-for-update')
    ); ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4><?php echo Yii::t('UpdateModule.update', 'Module update. Please, wait...');?></h4>
    </div>

    <div class="modal-body">

        <div class="progress progress-striped active">
            <div class="progress-bar" role="progressbar" style="width: 100%"></div>
        </div>

    </div>

    <?php $this->endWidget(); ?>
