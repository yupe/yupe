<?php
$this->breadcrumbs = array(
    Yii::t('YupeModule.yupe', 'Yupe!')   => array('settings'),
    Yii::t('YupeModule.yupe', 'Modules') => array('settings'),
    $module->name,
);
?>

<h1>
    <?php echo Yii::t('YupeModule.yupe', 'Module settings'); ?> "<?php echo CHtml::encode($module->name); ?>"
    <small><?php echo Yii::t('YupeModule.yupe', 'version'); ?> <?php echo CHtml::encode($module->version); ?></small>
</h1>

<br/>

<?php if (is_array($groups) && count($groups)): { ?>
    <?php echo CHtml::beginForm(
        array('/yupe/backend/saveModulesettings'),
        'post',
        array(
            'class' => 'well',
        )
    ); ?>
    <?php echo CHtml::hiddenField('module_id', $module->getId()); ?>
    <div class="row">
        <div class="col-sm-8">
            <?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); ?>
            <?php $i = 0; ?>
            <?php foreach ((array)$groups as $title => $items): ?>
                <?php $i++; ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#group-<?= $i ?>">
                                <?= $title ?>
                            </a>
                        </h4>
                    </div>
                    <div id="group-<?= $i ?>" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <?php foreach ((array)$items as $item): ?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <?= $item ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>


            <?php $this->endWidget(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?php echo CHtml::submitButton(
                Yii::t(
                    'YupeModule.yupe',
                    'Save "{{name}}" module settings',
                    array(
                        '{{name}}' => CHtml::encode($module->name)
                    )
                ),
                array(
                    'class' => 'btn btn-primary',
                    'id'    => 'saveModuleSettings',
                    'name'  => 'saveModuleSettings',
                )
            ); ?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
<?php } else: { ?>
    <b><?php echo Yii::t('YupeModule.yupe', 'There is no parameters which you cat change for this module...'); ?></b>
<?php } endif; ?>
