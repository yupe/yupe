<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id' => 'payment-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => array('class' => 'well'),
        'inlineErrors' => true,
    )
);
?>

    <div class="alert alert-info">
        <?php echo Yii::t('ShopModule.payment', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('ShopModule.payment', 'обязательны.'); ?>
    </div>

<?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo ($model->hasErrors('name') || $model->hasErrors('name')) ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'size' => 60, 'maxlength' => 250)); ?>
    </div>
    <div class="row-fluid control-group <?php echo ($model->hasErrors('status') || $model->hasErrors('status')) ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => '')); ?>
    </div>

    <div class="row-fluid control-group <?php echo ($model->hasErrors('module') || $model->hasErrors('module')) ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'module', array('manual' => 'Ручная обработка'), array('class' => '')); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget($this->module->editor, array(
            'model' => $model,
            'attribute' => 'description',
            'options' => $this->module->editorOptions,
        )); ?>
    </div>
<?php echo $form->hiddenField($model, 'position'); ?>

    <br/><br/>

<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => Yii::t('ShopModule.payment', 'Сохранить и продолжить'),
    ));
?>

<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label' => Yii::t('ShopModule.payment', 'Сохранить и вернуться к списку'),
    ));
?>

<?php $this->endWidget(); ?>