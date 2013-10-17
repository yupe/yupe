<?php
$this->breadcrumbs = array(
    Yii::t('YupeModule.yupe', 'System') => array('settings'),
    Yii::t('YupeModule.yupe', 'Modules') => array('settings'),
    $module->name,
);
?>

<h1>
    <?php echo Yii::t('YupeModule.yupe', 'Module settings'); ?> "<?php echo $module->name; ?>"
    <small><?php echo Yii::t('YupeModule.yupe','version'); ?> <?php echo $module->version; ?></small>
</h1>

<br/>

<?php if (is_array($elements) && count($elements)): ?>
    <?php echo CHtml::beginForm(array('/yupe/backend/saveModulesettings'), 'post', array(
        'class' => 'well',
    )); ?>
        <fieldset class="inline">
            <?php echo CHtml::hiddenField('module_id', $module->getId()); ?>

            <?php foreach ($elements as $element): ?>
                <div class="row-fluid control-group">
                    <div class="span8"><?php echo $element; ?></div>
                </div>
            <?php endforeach;?>
            <br />
            <?php echo CHtml::submitButton(Yii::t('YupeModule.yupe', 'Save "{{name}}" module settings', array(
                '{{name}}' => $module->name
            )), array(
                'class' => 'btn btn-primary',
                'id'    => 'saveModuleSettings',
                'name'  => 'saveModuleSettings',
            )); ?>
        </fieldset>
    <?php echo CHtml::endForm(); ?>
<?php else: ?>
    <b><?php echo Yii::t('YupeModule.yupe', 'There is no parameters which you cat change for this module...'); ?></b>
<?php endif; ?>