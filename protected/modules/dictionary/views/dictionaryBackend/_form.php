<script type='text/javascript'>
    $(document).ready(function () {
        $('#dictionary-form').liTranslit({
            elName: '#DictionaryGroup_name',
            elAlias: '#DictionaryGroup_code'
        });
    })
</script>


<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'dictionary-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
    )
); ?>

<div class="alert alert-info">
    <?php echo Yii::t('DictionaryModule.dictionary', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('DictionaryModule.dictionary', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'code'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 form-group">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            array(
                'model'     => $model,
                'attribute' => 'description',
            )
        ); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t(
                'DictionaryModule.dictionary',
                'Create dictionary and continue'
            ) : Yii::t('DictionaryModule.dictionary', 'Save dictionary and continue'),
    )
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t(
                'DictionaryModule.dictionary',
                'Create dictionary and close'
            ) : Yii::t('DictionaryModule.dictionary', 'Save dictionary and close'),
    )
); ?>

<?php $this->endWidget(); ?>
