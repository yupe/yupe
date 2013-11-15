<?php
/**
 * Отображение для dbsettings:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id'                     => 'dbsettings-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'inlineErrors'           => true,
    )
);

Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('application.modules.install.views.assets') . '/js/dbinstall.js'
    ), CClientScript::POS_END
);

Yii::app()->clientScript->registerScript(
    'dbtypes', '
    var dbTypes = ' . json_encode($data['model']->dbTypeNames) . ';
    var defaultAttr = {
        "mysql": ' . json_encode($data['model']->attributes) . ',
        "postgresql": ' . json_encode($data['model']->postgresqlDefaults) . '
    };
    ', CClientScript::POS_BEGIN
);

Yii::app()->clientScript->registerScript(
    'fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', delay : 500 });
    });", CClientScript::POS_READY
);
?>

    <?php $this->widget('install.widgets.GetHelpWidget');?>

    <div class="alert alert-block alert-info">
        <p><?php echo Yii::t('InstallModule.install', 'Select DB connection settings'); ?></p>
        <p><?php echo Yii::t('InstallModule.install', 'You can create DB with phpmyadmin help, or with some other sql tools.'); ?></p>
        <p><b><?php echo Yii::t('InstallModule.install', 'Yupe try to create DB if it doesn\'t exists.');?></p></b>
    </div>

    <?php if (!$data['result']) : ?>
        <div class="alert alert-block alert-error">
            <b><?php echo Yii::t('InstallModule.install', 'File {file} not exists or not accessible for write!', array('{file}' => $data['file'])); ?></b>
        </div>
    <?php endif; ?>

    <?php echo $form->errorSummary($data['model']); ?>

    <div class="alert alert-block alert-info">
        <p><?php echo '"' . $data['model']->getAttributeLabel('dbType') . '" - ' . Yii::t('InstallModule.install', 'This option is experiment. Only MySQL and PostgreSQL works stable.'); ?></p>
    </div>
    <div class="row-fluid control-group <?php echo $data['model']->hasErrors('dbType') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($data['model'], 'dbType', $data['model']->getDbTypeNames(), array('class' => 'popover-help span7', 'data-original-title' => $data['model']->getAttributeLabel('dbType'), 'data-content' => $data['model']->getAttributeDescription('dbType'))); ?>
    </div>

    <div class="row-fluid mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('host') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'host', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('host'), 'data-content' => $data['model']->getAttributeDescription('host'), 'autocomplete' => 'off')); ?>
    </div>

    <div class="row-fluid mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('port') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'port', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('port'), 'data-content' => $data['model']->getAttributeDescription('port'))); ?>
    </div>

    <div class="row-fluid mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('dbName') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'dbName', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('dbName'), 'data-content' => $data['model']->getAttributeDescription('dbName'), 'autocomplete' => 'off')); ?>
    </div>

    <div class="row-fluid mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('createDb') ? 'error' : ''; ?>">
        <?php echo $form->checkBoxRow($data['model'], 'createDb'); ?>
    </div>

    <div class="row-fluid mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('tablePrefix') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'tablePrefix', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('tablePrefix'), 'data-content' => $data['model']->getAttributeDescription('tablePrefix'))); ?>
    </div>

    <div class="row-fluid mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('dbUser') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'dbUser', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('dbUser'), 'data-content' => $data['model']->getAttributeDescription('dbUser'), 'autocomplete' => 'off')); ?>
    </div>

    <div class="row-fluid mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('dbPassword') ? 'error' : ''; ?>">
        <?php echo $form->passwordFieldRow($data['model'], 'dbPassword', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('dbPassword'), 'data-content' => $data['model']->getAttributeDescription('dbPassword'), 'autocomplete' => 'off')); ?>
    </div>

    <div class="row-fluid mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('socket') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'socket', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('socket'), 'data-content' => $data['model']->getAttributeDescription('socket') . ' (обязательно только при подключении через сокет)')); ?>
    </div>



<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'label' => Yii::t('InstallModule.install', '< Back'),
        'url'   => array('/install/default/requirements'),
    )
); ?>
&nbsp;
<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('InstallModule.install', 'Check connection and continue >'),
    )
); ?>

<?php $this->endWidget(); ?>
