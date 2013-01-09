<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'mail-event-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', delay : 500 });
    });
");
?>

    <div class="alert alert-info">
        <?php echo Yii::t('mail', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mail', 'обязательны.'); ?>
    </div>

    <?php echo  $form->errorSummary($model); ?>

    <div class='control-group <?php echo $model->hasErrors("code") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'code', array('class' => 'span7', 'maxlength' => 100)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("description") ? "error" : ""; ?>'>
        <?php echo $form->labelEx($model, 'description'); ?>
         <?php $this->widget($this->module->editor, array(
            'model'       => $model,
            'attribute'   => 'description',
            'options'     => $this->module->editorOptions,
        )); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('mail', 'Добавить событие и продолжить') : Yii::t('mail', 'Сохранить событие и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
       'buttonType'  => 'submit',
       'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
       'label'       => $model->isNewRecord ? Yii::t('mail', 'Добавить событие и закрыть') : Yii::t('mail', 'Сохранить событие и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>