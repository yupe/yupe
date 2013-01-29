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
        <?php echo Yii::t('CommentModule.comment', 'Поля, отмеченные'); ?>
        <span class="required">*</span> 
        <?php echo Yii::t('CommentModule.comment', 'обязательны.'); ?>
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
    <div class='control-group <?php echo $model->hasErrors("text") ? "error" : "" ?>'>
        <?php echo $form->textAreaRow($model, 'text', array('class' => 'span7')); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("status") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('CommentModule.comment', 'Добавить комментарий и продолжить') : Yii::t('CommentModule.comment', 'Сохранить комментарий и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
       'buttonType'  => 'submit',
       'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
       'label'       => $model->isNewRecord ? Yii::t('CommentModule.comment', 'Добавить комментарий и закрыть') : Yii::t('CommentModule.comment', 'Сохранить комментарий и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>
