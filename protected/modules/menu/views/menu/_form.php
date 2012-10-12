<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'menu-form',
    'enableAjaxValidation' => false,
    'htmlOptions'=> array('class' => 'well'),
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ 'delay': 500, });
    });
");
?>

     <fieldset class="inline">
         <div class="alert alert-info"><?php echo Yii::t('menu', 'Поля, отмеченные * обязательны для заполнения')?></div>

         <?php echo $form->errorSummary($model); ?>

         <div class="row-fluid control-group <?php echo $model->hasErrors('name')?'error':'' ?>">
             <div class="span7 popover-help" data-content="<?php echo Yii::t('menu', "Название меню, которое будет отображаться в списке меню.<br /><br />Например:<br /><pre>'Основное меню'</pre>") ?>" data-original-title="<?php echo $model-> getAttributeLabel('name'); ; ?>" >
                 <?php echo $form->labelEx($model, 'name'); ?>
                 <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150)); ?>
             </div>
             <div class="span5">
                 <?php echo $form->error($model, 'name'); ?>
             </div>
         </div>

         <div class="row-fluid control-group <?php echo $model->hasErrors('code')?'error':'' ?>">
             <div class="span7 popover-help" data-content="<?php echo Yii::t('menu', "Уникальный для каждого меню код.<br /><br />Например:<br /><pre>'MAIN_MENU'</pre>") ?>" data-original-title="<?php echo $model-> getAttributeLabel('code'); ; ?>" >
                 <?php echo $form->labelEx($model, 'code'); ?>
                 <?php echo $form->textField($model, 'code', array('size' => 60, 'maxlength' => 150)); ?>
             </div>
             <div class="span5">
                 <?php echo $form->error($model, 'code'); ?>
             </div>
         </div>

         <div class="row-fluid control-group <?php echo $model->hasErrors('description')?'error':'' ?>">
             <div class="span7 popover-help" data-content="<?php echo Yii::t('menu', "Простое текстовое описание.<br /><br />") ?>" data-original-title="<?php echo $model-> getAttributeLabel('description'); ; ?>" >
                 <?php echo $form->labelEx($model, 'description'); ?>
                 <?php echo $form->textArea($model, 'description'); ?>
             </div>
             <div class="span5">
                 <?php echo $form->error($model, 'description'); ?>
             </div>
         </div>

         <div class="row-fluid control-group <?php echo $model->hasErrors('status')?'error':'' ?>">
             <div class="span7  popover-help" data-content="<?php echo Yii::t('menu', "<span class='label label-success'>Активно</span> &ndash;Меню отображается на сайте.<br /><br /><span class='label label-default'>Не активно</span> &ndash; Меню не отображается на сайте.<br /><br />") ?>" data-original-title="<?php echo $model-> getAttributeLabel('status'); ; ?>" >
                 <?php echo $form->labelEx($model, 'status'); ?>
                 <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
             </div>
             <div class="span5">
                 <?php echo $form->error($model, 'status'); ?>
             </div>
         </div>


         <?php $this->widget('bootstrap.widgets.TbButton', array(
             'buttonType' => 'submit',
             'type'       => 'primary',
             'label'      => $model->isNewRecord ? Yii::t('menu', 'Добавить меню') : Yii::t('menu', 'Сохранить меню'),
         )); ?>
     </fieldset>
<?php $this->endWidget(); ?>