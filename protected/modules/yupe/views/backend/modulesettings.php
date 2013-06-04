<?php
$this->breadcrumbs = array(
    Yii::t('YupeModule.yupe', 'Система') => array('settings'),
    Yii::t('YupeModule.yupe', 'Модули') => array('settings'),
    $module->name,
);
?>

<h1>
    <?php echo Yii::t('YupeModule.yupe', 'Настройки модуля'); ?> "<?php echo $module->name; ?>"
    <small><?php echo Yii::t('YupeModule.yupe','версии'); ?> <?php echo $module->version; ?></small>
</h1>

<br/>

<?php if (is_array($elements) && count($elements)): ?>
    <?php echo CHtml::beginForm(array('/yupe/backend/saveModulesettings', 'post'), 'post', array(
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
            <?php echo CHtml::submitButton(Yii::t('YupeModule.yupe', 'Сохранить настройки модуля "{{name}}"', array(
                '{{name}}' => $module->name
            )), array(
                'class' => 'btn btn-primary',
                'id'    => 'saveModuleSettings',
                'name'  => 'saveModuleSettings',
            )); ?>
        </fieldset>
    <?php echo CHtml::endForm(); ?>
<?php else: ?>
    <b><?php echo Yii::t('YupeModule.yupe', 'К сожалению для данного модуля нет доступных для редактирования параметров...'); ?></b>
<?php endif; ?>