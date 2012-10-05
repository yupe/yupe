<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'contest-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ 'trigger' : 'hover', 'delay' : 500 });
    });
");
?>

    <div class="alert alert-info">
        <?php echo Yii::t('contest', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('contest', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 150, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'description', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 300, 'data-original-title' => $model->getAttributeLabel('description'), 'data-content' => $model->getAttributeDescription('description'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('start_add_image') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'start_add_image', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('start_add_image'), 'data-content' => $model->getAttributeDescription('start_add_image'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('stop_add_image') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'stop_add_image', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('stop_add_image'), 'data-content' => $model->getAttributeDescription('stop_add_image'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('start_vote') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'start_vote', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('start_vote'), 'data-content' => $model->getAttributeDescription('start_vote'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('stop_vote') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'stop_vote', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('stop_vote'), 'data-content' => $model->getAttributeDescription('stop_vote'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'status', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('contest', 'Сохранить конкурс и закрыть'),
    )); ?>

   <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
        'label'      => Yii::t('contest', 'Сохранить конкурс и продолжить'),
   )); ?>

<?php $this->endWidget(); ?>