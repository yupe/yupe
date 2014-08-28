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
    array(
        'id'                     => 'sitesettings-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
    )
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
            array(
                '{link}' => CHtml::link(
                        Yii::t('InstallModule.install', 'here'),
                        'http://help.yandex.ru/webmaster/?id=1108938',
                        array('target' => '_blank')
                    )
            )
        ); ?></p>
</div>

<?php echo $form->errorSummary($data['model']); ?>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $data['model'],
            'theme',
            array(
                'widgetOptions' => array(
                    'data'        => $data['themes'],
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('theme'),
                        'data-content'        => $data['model']->getAttributeDescription('theme'),
                    )
                )
            )
        ); ?>
    </div>
</div>

<?php if (!empty($data['backendThemes'])) : { ?>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->dropDownListGroup(
                $data['model'],
                'backendTheme',
                array(
                    'widgetOptions' => array(
                        'data'        => $data['backendThemes'],
                        'htmlOptions' => array(
                            'class'               => 'popover-help',
                            'data-original-title' => $data['model']->getAttributeLabel('backendTheme'),
                            'data-content'        => $data['model']->getAttributeDescription('backendTheme'),
                        )
                    )
                )
            ); ?>
        </div>
    </div>
<?php } endif; ?>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $data['model'],
            'siteName',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('siteName'),
                        'data-content'        => $data['model']->getAttributeDescription('siteName'),
                    )
                )
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textAreaGroup(
            $data['model'],
            'siteDescription',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('siteDescription'),
                        'data-content'        => $data['model']->getAttributeDescription('siteDescription'),
                        'rows'                => 6,
                    )
                )
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textAreaGroup(
            $data['model'],
            'siteKeyWords',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('siteKeyWords'),
                        'data-content'        => $data['model']->getAttributeDescription('siteKeyWords'),
                        'rows'                => 6,
                    )
                )
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $data['model'],
            'siteEmail',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('siteEmail'),
                        'data-content'        => $data['model']->getAttributeDescription('siteEmail'),
                    )
                )
            )
        ); ?>
    </div>
</div>

<?php echo CHtml::link(
    Yii::t('InstallModule.install', '< Back'),
    array('/install/default/createuser'),
    array('class' => 'btn btn-default')
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => Yii::t('InstallModule.install', 'Continue >'),
    )
); ?>

<?php $this->endWidget(); ?>
