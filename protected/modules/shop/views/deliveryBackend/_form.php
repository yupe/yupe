<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id' => 'delivery-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => array('class' => 'well'),
        'inlineErrors' => true,
    )
);
?>

    <div class="alert alert-info">
        <?php echo Yii::t('ShopModule.delivery', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('ShopModule.delivery', 'обязательны.'); ?>
    </div>

<?php echo $form->errorSummary($model); ?>
    <div class="row-fluid">
        <div class="span8">
            <div class="row-fluid control-group <?php echo ($model->hasErrors('name') || $model->hasErrors('name')) ? 'error' : ''; ?>">
                <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'size' => 60, 'maxlength' => 250)); ?>
            </div>
            <div class="row-fluid control-group <?php echo ($model->hasErrors('status') || $model->hasErrors('status')) ? 'error' : ''; ?>">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => '')); ?>
            </div>
            <div class="row-fluid control-group">
                <div class="span4 <?php echo $model->hasErrors('price') ? 'error' : ''; ?>">
                    <?php echo $form->textFieldRow($model, 'price', array('class' => '', 'size' => 60, 'maxlength' => 60)); ?>
                </div>
                <div class="span4 <?php echo $model->hasErrors('free_from') ? 'error' : ''; ?>">
                    <?php echo $form->textFieldRow($model, 'free_from', array('class' => '', 'size' => 60, 'maxlength' => 60)); ?>
                </div>
                <div class="span4 <?php echo $model->hasErrors('available_from') ? 'error' : ''; ?>">
                    <?php echo $form->textFieldRow($model, 'available_from', array('class' => '', 'size' => 60, 'maxlength' => 60)); ?>
                </div>

            </div>
            <div class="row-fluid control-group">
                <?php echo $form->checkBoxRow($model, 'separate_payment', array('class' => '',)); ?>
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
        </div>
        <div class="span4">
            <?php echo $form->checkBoxListRow($model, 'payment_methods', CHtml::listData(Payment::model()->published()->findAll(array('order' => 'position')), 'id', 'name'));?>
        </div>
    </div>

    <br/><br/>

<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => Yii::t('ShopModule.delivery', 'Сохранить и продолжить'),
    ));
?>

<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label' => Yii::t('ShopModule.delivery', 'Сохранить и вернуться к списку'),
    ));
?>

<?php $this->endWidget(); ?>