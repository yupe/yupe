<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'menu-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
)); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('MenuModule.menu', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('MenuModule.menu', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>">
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'popover-help span7', 'maxlength' => 300, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors("code") ? "error" : ""; ?>">
        <?php echo $form->textFieldRow($model, 'code', array('class' => 'popover-help span7', 'maxlength' => 300, 'data-original-title' => $model->getAttributeLabel('code'), 'data-content' => $model->getAttributeDescription('code'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors("description") ? "error" : ""; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('description'); ?>' data-content='<?php echo $model->getAttributeDescription('description'); ?>'>
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget($this->module->editor, array(
                'model'       => $model,
                'attribute'   => 'description',
                'options'     => $this->module->editorOptions,
            )); ?>
        </div>
     </div>
     <div class="row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : '' ?>">
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList, array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
     </div>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('MenuModule.menu', 'Добавить меню и продолжить') : Yii::t('MenuModule.menu', 'Сохранить меню и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('MenuModule.menu', 'Добавить меню и закрыть') : Yii::t('MenuModule.menu', 'Сохранить меню и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>
