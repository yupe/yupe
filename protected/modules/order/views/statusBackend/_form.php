<?php
/**
 * @var OrderStatus $model
 * @var TbActiveForm $form
 */

Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/color-selector.css');
Yii::app()->getClientScript()->registerScriptFile($this->module->getAssetsUrl() . '/js/color-selector.js', CClientScript::POS_END);
Yii::app()->getClientScript()->registerScript('color-selector', '$("#colorselector").colorselector();', CClientScript::POS_READY);

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id' => 'order-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => ['class' => 'well'],
    ]
);
?>

<div class="alert alert-info">
    <?= Yii::t('OrderModule.order', 'Fields with'); ?>
    <span class="required">*</span>
    <?= Yii::t('OrderModule.order', 'are required'); ?>
</div>

<?= $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-4">
        <?= $form->textFieldGroup($model, 'name'); ?>
    </div>
    <div class="col-sm-1">
        <?= $form->dropDownListGroup($model, 'color', ['widgetOptions' => [
            'data' => OrderHelper::colorNames(),
            'htmlOptions' => [
                'empty' => '',
                'id' => 'colorselector',
                'options' => OrderHelper::colorValues(),
            ]
        ]]) ?>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->getIsNewRecord() ? Yii::t('OrderModule.order', 'Add status and continue') : Yii::t('OrderModule.order', 'Save status and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->getIsNewRecord() ? Yii::t('OrderModule.order', 'Add status and close') : Yii::t('OrderModule.order', 'Save status and close'),
    ]
); ?>

<?php $this->endWidget(); ?>
