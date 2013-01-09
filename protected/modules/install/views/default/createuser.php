<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'createuser-form',
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

    <div class="alert alert-block alert-info">
        <p><?php echo Yii::t('install', 'Создайте учетную запись администратора сайта.'); ?></p>
        <p><?php echo Yii::t('install', 'Пожалуйста, указывайте сложный пароль, содержащий как цифры и буквы, так и специальные символы.'); ?></p>
        <p><?php echo Yii::t('install', 'Запомните, указанные на данном этапе данные, они Вам потребуются для доступа к панели управления.'); ?></p>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('userName') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'userName', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('userName'), 'data-content' => $model->getAttributeDescription('userName'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('email') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'email', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('email'), 'data-content' => $model->getAttributeDescription('email'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('password') ? 'error' : ''; ?>">
        <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('password'), 'data-content' => $model->getAttributeDescription('password'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('cPassword') ? 'error' : ''; ?>">
        <?php echo $form->passwordFieldRow($model, 'cPassword', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('cPassword'), 'data-content' => $model->getAttributeDescription('cPassword'))); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('install', '< Назад'),
        'url'   => array('/install/default/modulesinstall'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('install', 'Продолжить >'),
    )); ?>

<?php $this->endWidget(); ?>