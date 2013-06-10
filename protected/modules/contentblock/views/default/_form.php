<script type='text/javascript'>
    $(document).ready(function(){
        $('#content-block-form').liTranslit({
            elName: '#ContentBlock_name',
            elAlias: '#ContentBlock_code'
        });
    })
</script>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'content-block-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
)); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('type') ? 'error' : ''; ?>">
        <div class="span7">
            <?php echo $form->dropDownListRow($model, 'type', $model->getTypes(), array('class' => 'span7')); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'type'); ?>
        </div>
    </div>
    <div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 250)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("code") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'code', array('class' => 'span7', 'maxlength' => 100)); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('content') ? 'error' : ''; ?>">
        <div class="span12">
            <?php echo $form->labelEx($model, 'content'); ?>
            <?php $this->widget($this->yupe->editor, array(
                'model'       => $model,
                'attribute'   => 'content',
                'options'     => $this->module->editorOptions,
            )); ?>
            <?php echo $form->error($model, 'content'); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <div class="span12">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget($this->yupe->editor, array(
                'model'       => $model,
                'attribute'   => 'description',
                'options'     => $this->module->editorOptions,
            )); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('ContentBlockModule.contentblock', 'Добавить блок и продолжить') : Yii::t('ContentBlockModule.contentblock', 'Сохранить блок и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('ContentBlockModule.contentblock', 'Добавить блок и закрыть') : Yii::t('ContentBlockModule.contentblock', 'Сохранить блок и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>
