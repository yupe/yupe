<?php
$this->breadcrumbs = array(
    Yii::t('yupe', 'Настройки') => array('settings'),
    $module->getName()
);?>

<h1><?php echo Yii::t('yupe', 'Настройки модуля');?>   "<?php echo $module->getName();?>"</h1>

<br/>

<?php $this->widget('YModuleInfo', array('module' => $module)); ?>

<?php if (is_array($elements) && count($elements)): ?>


    <?php echo CHtml::beginForm(array('/yupe/backend/saveModulesettings', 'post'),'post',array('class'=>'well'));?>
    <fieldset class="inline">
    <?php echo CHtml::hiddenField('module_id', $module->getId());?>

    <?php foreach ($elements as $element): ?>
        <div class="row-fluid control-group">
            <div class="span8"><?php echo $element;?></div>
        </div>
    <?php endforeach;?>

    <br />   
    
    <?php echo CHtml::submitButton(Yii::t('yupe', 'Сохранить настройки модуля'), array('class'=> 'btn btn-primary','id' => 'saveModuleSettings', 'name' => 'saveModuleSettings'));?>
    </fieldset>
    <?php echo CHtml::endForm(); ?>

<?php else: ?>

<b><?php echo Yii::t('yupe', 'К сожалению для данного модуля нет доступных для редактирования параметров...');?></b>

<?php endif; ?>