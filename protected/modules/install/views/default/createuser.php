<?php
/**
 * Отображение для createuser:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id'                     => 'createuser-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'inlineErrors'           => true,
    )
);

Yii::app()->clientScript->registerScript(
    'fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', delay : 500 });
    });"
);
?>

    <?php $this->widget('install.widgets.GetHelpWidget');?>

    <div class="alert alert-block alert-info">
        <p><?php echo Yii::t('InstallModule.install', 'Create admin account'); ?></p>
        <p><?php echo Yii::t('InstallModule.install', 'Please select hard password with digits, alphas and special symbols.'); ?></p>
        <p><?php echo Yii::t('InstallModule.install', 'Memorize please. Data form this section will need you for Control Panel access'); ?></p>
    </div>

    <?php echo $form->errorSummary($data['model']); ?>

    <div class="row-fluid control-group <?php echo $data['model']->hasErrors('userName') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'userName', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('userName'), 'data-content' => $data['model']->getAttributeDescription('userName'), 'autocomplete' => 'off')); ?>
    </div>

    <div class="row-fluid control-group <?php echo $data['model']->hasErrors('userEmail') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'userEmail', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('userEmail'), 'data-content' => $data['model']->getAttributeDescription('userEmail'), 'autocomplete' => 'off')); ?>
    </div>

    <div class="row-fluid control-group <?php echo $data['model']->hasErrors('userPassword') ? 'error' : ''; ?>">
        <?php echo $form->passwordFieldRow($data['model'], 'userPassword', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('userPassword'), 'data-content' => $data['model']->getAttributeDescription('userPassword'), 'autocomplete' => 'off')); ?>
    </div>

    <div class="row-fluid control-group <?php echo $data['model']->hasErrors('cPassword') ? 'error' : ''; ?>">
        <?php echo $form->passwordFieldRow($data['model'], 'cPassword', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('cPassword'), 'data-content' => $data['model']->getAttributeDescription('cPassword'))); ?>
    </div>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'label' => Yii::t('InstallModule.install', '< Back'),
            'url'   => array('/install/default/modulesinstall'),
        )
    ); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => Yii::t('InstallModule.install', 'Continue >'),
        )
    ); ?>

<?php $this->endWidget(); ?>