<?php
/**
 * Отображение для createuser:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'                     => 'createuser-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
    ]
);

Yii::app()->clientScript->registerScript(
    'fieldset',
    "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', delay : 500 });
    });"
);
?>

<?php $this->widget('install.widgets.GetHelpWidget'); ?>

<div class="alert alert-info">
    <p><?php echo Yii::t('InstallModule.install', 'Create admin account'); ?></p>

    <p><?php echo Yii::t(
            'InstallModule.install',
            'Please select hard password with digits, alphas and special symbols.'
        ); ?></p>

    <p><?php echo Yii::t(
            'InstallModule.install',
            'Memorize please. Data form this section will need you for Control Panel access'
        ); ?></p>
</div>

<?php echo $form->errorSummary($data['model']); ?>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $data['model'],
            'userName',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('userName'),
                        'data-content'        => $data['model']->getAttributeDescription('userName'),
                        'autocomplete'        => 'off',
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $data['model'],
            'userEmail',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('userEmail'),
                        'data-content'        => $data['model']->getAttributeDescription('userEmail'),
                        'autocomplete'        => 'off',
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->passwordFieldGroup(
            $data['model'],
            'userPassword',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('userPassword'),
                        'data-content'        => $data['model']->getAttributeDescription('userPassword'),
                        'autocomplete'        => 'off',
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->passwordFieldGroup(
            $data['model'],
            'cPassword',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('cPassword'),
                        'data-content'        => $data['model']->getAttributeDescription('cPassword'),
                        'autocomplete'        => 'off',
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<?php echo CHtml::link(
    Yii::t('InstallModule.install', '< Back'),
    ['/install/default/modulesinstall'],
    ['class' => 'btn btn-default']
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => Yii::t('InstallModule.install', 'Continue >'),
    ]
); ?>

<?php $this->endWidget(); ?>
