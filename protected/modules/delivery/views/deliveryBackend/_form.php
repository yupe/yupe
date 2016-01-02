<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id' => 'delivery-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => ['class' => 'well'],
    ]
);
?>

<div class="alert alert-info">
    <?= Yii::t('DeliveryModule.delivery', 'Fields with'); ?>
    <span class="required">*</span>
    <?= Yii::t('DeliveryModule.delivery', 'are required'); ?>
</div>

<?= $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-7">
                <?= $form->dropDownListGroup(
                    $model,
                    'status',
                    [
                        'widgetOptions' => [
                            'data' => $model->getStatusList(),
                        ],
                    ]
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->textFieldGroup($model, 'name'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->textFieldGroup($model, 'price'); ?>
            </div>
            <div class="col-sm-4">
                <?= $form->textFieldGroup($model, 'free_from'); ?>
            </div>
            <div class="col-sm-4">
                <?= $form->textFieldGroup($model, 'available_from'); ?>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->checkBoxGroup($model, 'separate_payment'); ?>
            </div>
        </div>
        <div class='row'>
            <div class="col-sm-12 <?= $model->hasErrors('description') ? 'has-error' : ''; ?>">
                <?= $form->labelEx($model, 'description'); ?>
                <?php $this->widget(
                    $this->module->getVisualEditor(),
                    [
                        'model' => $model,
                        'attribute' => 'description',
                    ]
                ); ?>
                <p class="help-block"></p>
                <?= $form->error($model, 'description'); ?>
            </div>
        </div>
        <?= $form->hiddenField($model, 'position'); ?>
    </div>

    <?php if(!empty($payments)):?>
    <div class="col-sm-4">
        <?= $form->checkBoxListGroup(
            $model,
            'payment_methods',
            [
                'widgetOptions' => [
                    'data' => CHtml::listData($payments, 'id', 'name'),
                ],
            ]
        );?>
    </div>
    <?php endif;?>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->getIsNewRecord() ? Yii::t('DeliveryModule.delivery', 'Add delivery and continue') : Yii::t('DeliveryModule.delivery', 'Save delivery and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->getIsNewRecord() ? Yii::t('DeliveryModule.delivery', 'Add delivery and close') : Yii::t('DeliveryModule.delivery', 'Save delivery and close'),
    ]
); ?>

<?php $this->endWidget(); ?>
