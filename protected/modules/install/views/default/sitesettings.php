<?php
/**
 * Отображение для sitesettings:
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
        'id'                     => 'sitesettings-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
    ]
);

Yii::app()->clientScript->registerScript(
    'fieldset',
    "$('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', delay : 500 });
    });"
); ?>

<?php $this->widget('install.widgets.GetHelpWidget'); ?>

<div class="alert alert-info">
    <p><?php echo Yii::t('InstallModule.install', 'Select your site title, description and keywords for SEO.'); ?></p>

    <p><?php echo Yii::t(
            'InstallModule.install',
            'More about SEO {link}',
            [
                '{link}' => CHtml::link(
                        Yii::t('InstallModule.install', 'here'),
                        'http://help.yandex.ru/webmaster/?id=1108938',
                        ['target' => '_blank']
                    )
            ]
        ); ?></p>
</div>

<?php echo $form->errorSummary($data['model']); ?>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $data['model'],
            'theme',
            [
                'widgetOptions' => [
                    'data'        => $data['themes'],
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('theme'),
                        'data-content'        => $data['model']->getAttributeDescription('theme'),
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<?php if (!empty($data['backendThemes'])) : { ?>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->dropDownListGroup(
                $data['model'],
                'backendTheme',
                [
                    'widgetOptions' => [
                        'data'        => $data['backendThemes'],
                        'htmlOptions' => [
                            'class'               => 'popover-help',
                            'data-original-title' => $data['model']->getAttributeLabel('backendTheme'),
                            'data-content'        => $data['model']->getAttributeDescription('backendTheme'),
                        ]
                    ]
                ]
            ); ?>
        </div>
    </div>
<?php } endif; ?>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $data['model'],
            'siteName',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('siteName'),
                        'data-content'        => $data['model']->getAttributeDescription('siteName'),
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textAreaGroup(
            $data['model'],
            'siteDescription',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('siteDescription'),
                        'data-content'        => $data['model']->getAttributeDescription('siteDescription'),
                        'rows'                => 6,
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textAreaGroup(
            $data['model'],
            'siteKeyWords',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('siteKeyWords'),
                        'data-content'        => $data['model']->getAttributeDescription('siteKeyWords'),
                        'rows'                => 6,
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
            'siteEmail',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('siteEmail'),
                        'data-content'        => $data['model']->getAttributeDescription('siteEmail'),
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<?php echo CHtml::link(
    Yii::t('InstallModule.install', '< Back'),
    ['/install/default/createuser'],
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
