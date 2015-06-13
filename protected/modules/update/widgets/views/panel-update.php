<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbCollapse', [
        'htmlOptions' => [
            'id' => 'panel-update-stat'
        ]
    ]
);?>

<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#<?= $this->getId(); ?>">
                    <i class="fa fa-fw fa-refresh"></i> <?php echo Yii::t('UpdateModule.update', 'Updates'); ?>
                </a>
                <span class="badge alert-success"><?php echo $count; ?></span>
            </h4>
        </div>


        <div id="<?= $this->getId(); ?>" class="panel-collapse collapse">
            <div class="panel-body">

                <?php if($count):?>
                    <div class="alert alert-warning" role="alert">
                        <?= Yii::t('UpdateModule.update', 'Available updates: total !', ['total' => CHtml::link($count, ['/update/updateBackend/index'])]); ?>
                    </div>
                <?php else:?>
                    <div class="alert alert-success" role="alert">
                        <?= Yii::t('UpdateModule.update', 'You have the most current version');?> <?= CHtml::link(Yii::t('UpdateModule.update', 'Check ?'), ['/update/updateBackend/index']);?>
                    </div>
                <?php endif;?>

            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
