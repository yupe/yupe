<?php
/**
 * Отображение для dbsettings:
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
        'id'                     => 'dbsettings-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
    ]
);

Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('application.modules.install.views.assets') . '/js/dbinstall.js'
    ),
    CClientScript::POS_END
);

Yii::app()->clientScript->registerScript(
    'dbtypes',
    '
    var dbTypes = ' . json_encode($data['model']->dbTypeNames) . ';
    var defaultAttr = {
        "mysql": ' . json_encode($data['model']->attributes) . '
    };
    ',
    CClientScript::POS_BEGIN
);

Yii::app()->clientScript->registerScript(
    'fieldset',
    "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', delay : 500 });
    });",
    CClientScript::POS_READY
);
?>

<?php $this->widget('install.widgets.GetHelpWidget'); ?>

<div class="alert alert-info">
    <p><?php echo Yii::t('InstallModule.install', 'Select DB connection settings'); ?></p>

    <p><?php echo Yii::t(
            'InstallModule.install',
            'You can create DB with phpmyadmin help, or with some other sql tools.'
        ); ?></p>

    <p><b><?php echo Yii::t('InstallModule.install', 'Yupe try to create DB if it doesn\'t exists.'); ?></p></b>
</div>

<?php if (!$data['result']) : { ?>
    <div class="alert alert-danger">
        <b><?php echo Yii::t(
                'InstallModule.install',
                'File {file} not exists or not accessible for write!',
                ['{file}' => $data['file']]
            ); ?></b>
    </div>
<?php } endif; ?>

<?php echo $form->errorSummary($data['model']); ?>

<div class="alert alert-info">
    <p><?php echo '"' . $data['model']->getAttributeLabel('dbType') . '" - ' . Yii::t(
                'InstallModule.install',
                'This option is experiment. Only MySQL works stable.'
            ); ?></p>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $data['model'],
            'dbType',
            [
                'widgetOptions' => [
                    'data'        => $data['model']->getDbTypeNames(),
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('dbType'),
                        'data-content'        => $data['model']->getAttributeDescription('dbType')
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row mysql-enable">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $data['model'],
            'host',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('host'),
                        'data-content'        => $data['model']->getAttributeDescription('host'),
                        'autocomplete'        => 'off',
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row mysql-enable">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $data['model'],
            'port',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('port'),
                        'data-content'        => $data['model']->getAttributeDescription('port'),
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row mysql-enable">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $data['model'],
            'dbName',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('dbName'),
                        'data-content'        => $data['model']->getAttributeDescription('dbName'),
                        'autocomplete'        => 'off',
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row mysql-enable">
    <div class="col-sm-7">
        <?php echo $form->checkBoxGroup($data['model'], 'createDb'); ?>
    </div>
</div>

<div class="row mysql-enable">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $data['model'],
            'tablePrefix',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('tablePrefix'),
                        'data-content'        => $data['model']->getAttributeDescription('tablePrefix'),
                        'autocomplete'        => 'off',
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row mysql-enable">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $data['model'],
            'dbUser',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('dbUser'),
                        'data-content'        => $data['model']->getAttributeDescription('dbUser'),
                        'autocomplete'        => 'off',
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row mysql-enable">
    <div class="col-sm-7">
        <?php echo $form->passwordFieldGroup(
            $data['model'],
            'dbPassword',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('dbPassword'),
                        'data-content'        => $data['model']->getAttributeDescription('dbPassword'),
                        'autocomplete'        => 'off',
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row mysql-enable">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $data['model'],
            'socket',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $data['model']->getAttributeLabel('socket'),
                        'data-content'        => $data['model']->getAttributeDescription(
                                'socket'
                            ) . ' (обязательно только при подключении через сокет)',
                        'autocomplete'        => 'off',
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<br/>

<?php echo CHtml::link(
    Yii::t('InstallModule.install', '< Back'),
    ['/install/default/requirements'],
    ['class' => 'btn btn-default']
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => Yii::t('InstallModule.install', 'Check connection and continue >'),
    ]
); ?>

<?php $this->endWidget(); ?>
