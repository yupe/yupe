<?php
$this->breadcrumbs = array(
    Yii::t('yupe', 'Настройки') => array('settings'),
    $module->getName()
);?>

<h1><?php echo Yii::t('yupe', 'Настройки модуля');?>   "<?php echo $module->getName();?>"</h1>

<?php $this->widget('YModuleInfo', array('module' => $module)); ?>

<?php if (is_array($module->checkSelf())): ?>
    <?php $error = $module->checkSelf(); ?>
    <div class="flash-<?php echo $error['type'];?>">
        <b><?php echo Yii::t('yupe','Модуль "{module} ({id})"',array(
            '{module}' => $module->getName(),
            '{id}'     => $module->id
            ));?>:<br/> <?php echo $error['message'];?></b>
    </div>
<?php endif; ?>

<?php if (is_array($elements) && count($elements)): ?>

<div class="form">

    <?php echo CHtml::beginForm(array('/yupe/backend/saveModulesettings', 'post')); ?>

    <?php echo CHtml::hiddenField('module_id', $module->getId());?>

    <?php foreach ($elements as $element): ?>

    <div class="row">        
        <?php echo $element;?>
    </div>

    <?php endforeach;?>

    <div class="row submit">
        <?php echo CHtml::submitButton(Yii::t('yupe', 'Сохранить настройки модуля'), array('id' => 'saveModuleSettings', 'name' => 'saveModuleSettings'));?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div>

<?php else: ?>

<b><?php echo Yii::t('yupe', 'К сожалению для данного модуля нет доступных для редактирования параметров...');?></b>

<?php endif; ?>