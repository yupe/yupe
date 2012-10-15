<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'dbsettings-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'inlineErrors'           => true,
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', 'delay' : 500 });
    });
");
?>

    <div class="alert alert-info">
        <?php echo Yii::t('install', 'Укажите параметры соединения с базой данных'); ?>:
    </div>

    <?php if (!$result): ?>
        <div class="flash-error">
            <b><?php echo Yii::t('install', "Файл {file} не существует или не доступен для записи!", array('{file}' => $file)); ?></b>
        </div>
    <?php endif; ?>

    <?php if (!$sqlResult): ?>
        <div class="flash-error">
            <b><?php echo Yii::t('install', "Файл {file} не существует или не доступен для чтения!", array('{file}' => $sqlFile)); ?></b>
        </div>
    <?php endif; ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('host') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'host', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('host'), 'data-content' => $model->getAttributeDescription('host'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('port') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'port', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('port'), 'data-content' => $model->getAttributeDescription('port'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('socket') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'socket', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('socket'), 'data-content' => $model->getAttributeDescription('socket') . '(не обязательно)')); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('dbName') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'dbName', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('dbName'), 'data-content' => $model->getAttributeDescription('dbName'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('user') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'user', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('user'), 'data-content' => $model->getAttributeDescription('user'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('password') ? 'error' : ''; ?>">
        <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('password'), 'data-content' => $model->getAttributeDescription('password'))); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('install', '< Назад'),
        'url'   => array('default/requirements'),
    )); ?>
    <?php if ($result && $sqlResult): ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => Yii::t('install', 'Продолжить >'),
        )); ?>
    <?php endif; ?>

<?php $this->endWidget(); ?>