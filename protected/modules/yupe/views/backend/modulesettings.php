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

<?php if (is_array($elements) && count($elements)): { ?>
    <?php echo CHtml::beginForm(
        array('/yupe/backend/saveModulesettings'),
        'post',
        array(
            'class' => 'well',
        )
    ); ?>
    <fieldset class="inline">
        <?php echo CHtml::hiddenField('module_id', $module->getId()); ?>

        <?php foreach ($elements as $element): { ?>
            <div class="row">
                <div class="col-xs-8 form-group"><?php echo $element; ?></div>
            </div>
        <?php } endforeach; ?>
        <br/>
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
    </fieldset>
    <?php echo CHtml::endForm(); ?>
<?php } else: { ?>
    <b><?php echo Yii::t('YupeModule.yupe', 'There is no parameters which you cat change for this module...'); ?></b>
<?php } endif; ?>
