<?php
/**
 * Отображение для sitesettings:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id'                     => 'sitesettings-form',
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
); ?>

    <div class="alert alert-block alert-info">
        <p><?php echo Yii::t('InstallModule.install', 'Укажите название Вашего сайта, его описание и ключевые слова, необходимые для SEO-оптимизации.'); ?></p>
        <p><?php echo Yii::t('InstallModule.install', 'Узнать больше о SEO-оптимизации можно {link}.', array('{link}' => CHtml::link(Yii::t('InstallModule.install', 'вот здесь'), 'http://help.yandex.ru/webmaster/?id=1108938', array('target' => '_blank')))); ?></p>
    </div>

    <?php echo $form->errorSummary($data['model']); ?>  

    <div class="row-fluid control-group <?php echo $data['model']->hasErrors('theme') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($data['model'], 'theme', $data['themes'], array('class' => 'popover-help span7', 'data-original-title' => $data['model']->getAttributeLabel('theme'), 'data-content' => $data['model']->getAttributeDescription('theme'))); ?>
    </div> 

    <?php if(!empty($data['backendThemes'])) : ?>
        <div class="row-fluid control-group <?php echo $data['model']->hasErrors('backendTheme') ? 'error' : ''; ?>">
            <?php echo $form->dropDownListRow($data['model'], 'backendTheme', $data['backendThemes'], array('class' => 'popover-help span7', 'data-original-title' => $data['model']->getAttributeLabel('backendTheme'), 'data-content' => $data['model']->getAttributeDescription('backendTheme'))); ?>
        </div> 
    <?php endif; ?>

    <div class="row-fluid control-group <?php echo $data['model']->hasErrors('siteName') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'siteName', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('siteName'), 'data-content' => $data['model']->getAttributeDescription('siteName'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $data['model']->hasErrors('siteDescription') ? 'error' : ''; ?>">
        <?php echo $form->textAreaRow($data['model'], 'siteDescription', array('class' => 'span7 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $data['model']->getAttributeLabel('siteDescription'), 'data-content' => $data['model']->getAttributeDescription('siteDescription'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $data['model']->hasErrors('siteKeyWords') ? 'error' : ''; ?>">
        <?php echo $form->textAreaRow($data['model'], 'siteKeyWords', array('class' => 'span7 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $data['model']->getAttributeLabel('siteKeyWords'), 'data-content' => $data['model']->getAttributeDescription('siteKeyWords'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $data['model']->hasErrors('siteEmail') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'siteEmail', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('siteEmail'), 'data-content' => $data['model']->getAttributeDescription('siteEmail'))); ?>
    </div>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'label' => Yii::t('InstallModule.install', '< Назад'),
            'url'   => array('/install/default/createuser'),
        )
    ); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => Yii::t('InstallModule.install', 'Продолжить >'),
        )
    ); ?>

<?php $this->endWidget(); ?>