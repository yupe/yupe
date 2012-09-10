<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'good-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well form-vertical'),
    'inlineErrors'           => true,
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ 'trigger' : 'hover', 'delay' : 500 });
    });
");
?>

    <div class="alert alert-info">
        <?php echo Yii::t('catalog', 'Поля, отмеченные'); ?>        <span class="required">*</span>
        <?php echo Yii::t('catalog', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('category_id') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'category_id', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 10, 'data-original-title' => $model->getAttributeLabel('category_id'), 'data-content' => $model->getAttributeDescription('category_id'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 150, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('price') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'price', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('price'), 'data-content' => $model->getAttributeDescription('price'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('article') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'article', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 100, 'data-original-title' => $model->getAttributeLabel('article'), 'data-content' => $model->getAttributeDescription('article'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('image') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'image', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 300, 'data-original-title' => $model->getAttributeLabel('image'), 'data-content' => $model->getAttributeDescription('image'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('short_description') ? 'error' : ''; ?>">
        <?php echo $form->textAreaRow($model, 'short_description', array('class' => 'span5 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $model->getAttributeLabel('short_description'), 'data-content' => $model->getAttributeDescription('short_description'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <?php echo $form->textAreaRow($model, 'description', array('class' => 'span5 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $model->getAttributeLabel('description'), 'data-content' => $model->getAttributeDescription('description'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('alias') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'alias', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 100, 'data-original-title' => $model->getAttributeLabel('alias'), 'data-content' => $model->getAttributeDescription('alias'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('data') ? 'error' : ''; ?>">
        <?php echo $form->textAreaRow($model, 'data', array('class' => 'span5 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $model->getAttributeLabel('data'), 'data-content' => $model->getAttributeDescription('data'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('is_special') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'is_special', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('is_special'), 'data-content' => $model->getAttributeDescription('is_special'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'status', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('create_time') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'create_time', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('create_time'), 'data-content' => $model->getAttributeDescription('create_time'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('update_time') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'update_time', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('update_time'), 'data-content' => $model->getAttributeDescription('update_time'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('user_id') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'user_id', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 10, 'data-original-title' => $model->getAttributeLabel('user_id'), 'data-content' => $model->getAttributeDescription('user_id'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('change_user_id') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'change_user_id', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 10, 'data-original-title' => $model->getAttributeLabel('change_user_id'), 'data-content' => $model->getAttributeDescription('change_user_id'))); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('catalog', $model->isNewRecord ? 'Добавить товар и закрыть' : 'Сохранить товар и закрыть'),
    )); ?>
   <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
        'label'      => Yii::t('catalog', $model->isNewRecord ? 'Добавить товар и продолжить' : 'Сохранить товар и продолжить'),
    )); ?>

<?php $this->endWidget(); ?>