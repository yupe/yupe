<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'sitesettings-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'inlineErrors'           => true,
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', delay : 500 });
    });
");
?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('email') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'email', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('email'), 'data-content' => $model->getAttributeDescription('email'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('siteName') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'siteName', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('siteName'), 'data-content' => $model->getAttributeDescription('siteName'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('siteDescription') ? 'error' : ''; ?>">
        <?php echo $form->textAreaRow($model, 'siteDescription', array('class' => 'span7 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $model->getAttributeLabel('siteDescription'), 'data-content' => $model->getAttributeDescription('siteDescription'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('siteKeyWords') ? 'error' : ''; ?>">
        <?php echo $form->textAreaRow($model, 'siteKeyWords', array('class' => 'span7 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $model->getAttributeLabel('siteKeyWords'), 'data-content' => $model->getAttributeDescription('siteKeyWords'))); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('install', '< Назад'),
        'url'   => array('/install/default/createuser'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('install', 'Продолжить >'),
    )); ?>

<?php $this->endWidget(); ?>