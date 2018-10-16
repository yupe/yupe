<?php
/**
 * @var $this DictionaryDataBackendController
 * @var $model DictionaryData
 * @var $form \yupe\widgets\ActiveForm
 */
$form = $this->beginWidget(
    'yupe\widgets\ActiveForm',
    [
        'id'                     => 'dictionary-data-form',
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

<div class="row">
    <div class="col-sm-3">
        <?=  $form->dropDownListGroup(
            $model,
            'group_id',
            [
                'widgetOptions' => [
                    'data' => CHtml::listData(DictionaryGroup::model()->findAll(), 'id', 'name')
                ]
            ]
        ); ?>

    </div>
    <div class="col-sm-3">
        <?=  $form->dropDownListGroup(
            $model,
            'status',
            ['widgetOptions' => ['data' => $model->getStatusList()]]
        ); ?>
    </div>
</div>

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

<div class='row'>
    <div class="col-sm-7">
        <?=  $form->textFieldGroup($model, 'value'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 form-group popover-help"
         data-original-title='<?=  $model->getAttributeLabel('description'); ?>'
         data-content='<?=  $model->getAttributeDescription('description'); ?>'>
        <?=  $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->yupe->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'description',
            ]
        ); ?>
    </div>
</div>


<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t(
            'DictionaryModule.dictionary',
            'Create item and continue'
        ) : Yii::t('DictionaryModule.dictionary', 'Save value and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t('DictionaryModule.dictionary', 'Create item and close') : Yii::t(
            'DictionaryModule.dictionary',
            'Save value and close'
        ),
    ]
); ?>

<?php $this->endWidget(); ?>
