<?php
/**
 * @var $this DictionaryBackendController
 * @var $model DictionaryGroup
 * @var $form \yupe\widgets\ActiveForm
 */
$form = $this->beginWidget(
    'yupe\widgets\ActiveForm',
    [
        'id'                     => 'dictionary-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well'],
    ]
); ?>

<div class="alert alert-info">
    <?=  Yii::t('DictionaryModule.dictionary', 'Fields with'); ?>
    <span class="required">*</span>
    <?=  Yii::t('DictionaryModule.dictionary', 'are required.'); ?>
</div>

<?=  $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-7">
        <?=  $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?=  $form->slugFieldGroup($model, 'code', ['sourceAttribute' => 'name']); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 form-group">
        <?=  $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'description',
            ]
        ); ?>
        <?=  $form->error($model, 'description'); ?>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t(
            'DictionaryModule.dictionary',
            'Create dictionary and continue'
        ) : Yii::t('DictionaryModule.dictionary', 'Save dictionary and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t(
            'DictionaryModule.dictionary',
            'Create dictionary and close'
        ) : Yii::t('DictionaryModule.dictionary', 'Save dictionary and close'),
    ]
); ?>

<?php $this->endWidget(); ?>
