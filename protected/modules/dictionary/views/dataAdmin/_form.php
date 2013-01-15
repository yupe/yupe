<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'dictionary-data-form',
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
        <?php echo Yii::t('DictionaryModule.dictionary', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('DictionaryModule.dictionary', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class='control-group <?php echo $model->hasErrors("group_id") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'group_id', CHtml::listData(DictionaryGroup::model()->findAll(), 'id', 'name')); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("code") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'code', array('class' => 'span7', 'maxlength' => 100)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("value") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'value', array('class' => 'span7', 'maxlength' => 100)); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('description'); ?>' data-content='<?php echo $model->getAttributeDescription('description'); ?>'>
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget($this->module->editor, array(
                'model'       => $model,
                'attribute'   => 'description',
                'options'     => $this->module->editorOptions,
            )); ?>
        </div>
    </div>
    <div class='control-group <?php echo $model->hasErrors("status") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('DictionaryModule.dictionary', 'Добавить значение и продолжить') : Yii::t('DictionaryModule.dictionary', 'Сохранить значение и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('DictionaryModule.dictionary', 'Добавить значение и закрыть') : Yii::t('DictionaryModule.dictionary', 'Сохранить значение и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>