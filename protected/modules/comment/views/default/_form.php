<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'comment-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
)); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('CommentModule.comment', 'Fields with'); ?>
        <span class="required">*</span> 
        <?php echo Yii::t('CommentModule.comment', 'are require.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class='control-group <?php echo $model->hasErrors("model") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'model', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("model_id") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'model_id', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("email") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'email', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("url") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'url', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class='row-fluid control-group <?php echo $model->hasErrors("text") ? "error" : ""; ?>'>
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php $this->widget($this->module->editor, array(
                'model'       => $model,
                'attribute'   => 'text',
                'options'     => $this->module->editorOptions,
            )); ?>
        <br /><?php echo $form->error($model, 'text'); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("status") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('CommentModule.comment', 'Create comment and continue') : Yii::t('CommentModule.comment', 'Save comment and continue'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
       'buttonType'  => 'submit',
       'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
       'label'       => $model->isNewRecord ? Yii::t('CommentModule.comment', 'Create comment and close') : Yii::t('CommentModule.comment', 'Save comment and close'),
    )); ?>

<?php $this->endWidget(); ?>
