<?php
/**
 * @var OrderStatus $model
 * @var TbActiveForm $form
 */

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
    <?php echo Yii::t('OrderModule.order', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('OrderModule.order', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
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
