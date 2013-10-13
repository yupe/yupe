<script type='text/javascript'>
    $(document).ready(function(){
        $('#dictionary-form').liTranslit({
            elName: '#DictionaryGroup_name',
            elAlias: '#DictionaryGroup_code'
        });
    })
</script>


<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'dictionary-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
)); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('DictionaryModule.dictionary', 'Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('DictionaryModule.dictionary', 'are required.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>

    <div class='control-group <?php echo $model->hasErrors("code") ? "error" : ""; ?>'>
         <?php echo $form->textFieldRow($model, 'code', array('class' => 'span7', 'maxlength' => 100)); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <div class="span12">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget($this->module->editor, array(
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
        'label'      => $model->isNewRecord ? Yii::t('DictionaryModule.dictionary', 'Create dictionary and continue') : Yii::t('DictionaryModule.dictionary', 'Save dictionary and continue'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('DictionaryModule.dictionary', 'Create dictionary and close') : Yii::t('DictionaryModule.dictionary', 'Save dictionary and close'),
    )); ?>

<?php $this->endWidget(); ?>
