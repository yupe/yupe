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

    <div class="alert alert-block alert-info">
        <p><?php echo Yii::t('InstallModule.install', 'Укажите название Вашего сайта, его описание и ключевые слова, необходимые для SEO-оптимизации.'); ?></p>
        <p><?php echo Yii::t('InstallModule.install', 'Узнать больше о SEO-оптимизации можно {link}.',array('{link}' => CHtml::link(Yii::t('InstallModule.install','вот здесь'),'http://help.yandex.ru/webmaster/?id=1108938',array('target' => '_blank')))); ?></p>
    </div>

    <?php echo $form->errorSummary($model); ?>   

    <div class="row-fluid control-group <?php echo $model->hasErrors('siteName') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'siteName', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('siteName'), 'data-content' => $model->getAttributeDescription('siteName'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('siteDescription') ? 'error' : ''; ?>">
        <?php echo $form->textAreaRow($model, 'siteDescription', array('class' => 'span7 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $model->getAttributeLabel('siteDescription'), 'data-content' => $model->getAttributeDescription('siteDescription'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('siteKeyWords') ? 'error' : ''; ?>">
        <?php echo $form->textAreaRow($model, 'siteKeyWords', array('class' => 'span7 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $model->getAttributeLabel('siteKeyWords'), 'data-content' => $model->getAttributeDescription('siteKeyWords'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('email') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'email', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('email'), 'data-content' => $model->getAttributeDescription('email'))); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('InstallModule.install', '< Назад'),
        'url'   => array('/install/default/createuser'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('InstallModule.install', 'Продолжить >'),
    )); ?>

<?php $this->endWidget(); ?>