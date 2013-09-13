<script type='text/javascript'>
    $(document).ready(function(){
        $('#mail-template-form').liTranslit({
            elName: '#MailTemplate_name',
            elAlias: '#MailTemplate_code'
        });
    })
</script>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'mail-template-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
)); ?>

    <div class="alert alert-info">
        <?php echo Yii::t('MailModule.mail', 'Fields, with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('MailModule.mail', 'are required.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class='control-group <?php echo $model->hasErrors("event_id") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'event_id', CHtml::listData(MailEvent::model()->findAll(), 'id', 'name'), array('class' => 'span7', 'maxlength' => 10, 'empty' => Yii::t('MailModule.mail', '--choose--'))); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("code") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'code', array('class' => 'span7', 'maxlength' => 100)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("from") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'from', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("to") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'to', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("theme") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'theme', array('rows' => 6, 'cols' => 50, 'class' => 'span7')); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("body") ? "error" : ""; ?>'>
         <?php echo $form->labelEx($model, 'body'); ?>
         <?php $this->widget($this->module->editor, array(
            'model'       => $model,
            'attribute'   => 'body',
            'options'     => $this->module->editorOptions,
        )); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("description") ? "error" : ""; ?>'>
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget($this->module->editor, array(
            'model'       => $model,
            'attribute'   => 'description',
            'options'     => $this->module->editorOptions,
        )); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("status") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'span7')); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('MailModule.mail', 'Create template and continue') : Yii::t('MailModule.mail', 'Save template and continue'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
       'buttonType'  => 'submit',
       'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
       'label'       => $model->isNewRecord ? Yii::t('MailModule.mail', 'Create template and close') : Yii::t('MailModule.mail', 'Save template and close'),
    )); ?>

<?php $this->endWidget(); ?>
