<?php
/**
 * Отображение для dbsettings:
 *
 *   @category YupeView
 *   @package  YupeCMS
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
        "postgresql": ' . json_encode($data['model']->postgresqlDefaults) . ',
        "sqlite": ' . json_encode($data['model']->sqliteDefaults) . '
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

    <div class="alert alert-block alert-info">
        <p><b><?php echo Yii::t('InstallModule.install','При возникновении проблем с установкой, пожалуйста, посетите вот эту {link} ветку форума!',array(
                        '{link}' => CHtml::link('http://yupe.ru/talk/viewforum.php?id=10','http://yupe.ru/talk/viewforum.php?id=10',array('target' => '_blank'))
                    ));?></b></p>
    </div>


    <div class="alert alert-block alert-info">
        <p><?php echo Yii::t('InstallModule.install', 'Укажите параметры соединения с существующей базой данных.'); ?></p>
        <p><?php echo Yii::t('InstallModule.install', 'Базу данных можно создать при помощи phpmyadmin или любого другого инструмента.'); ?></p>
        <p><?php echo Yii::t('InstallModule.install', 'Юпи! попытается сам саздать базу данных если Вы поставите галочку "Создать базу данных"');?></p>
    </div>

    <div class="alert alert-block alert-info sqlite-enable mysql-disable postgresql-disable">
        <p><b><?php echo Yii::t('InstallModule.install', 'Касательно СУБД SQLite.'); ?></b></p>
        <p><?php echo Yii::t('InstallModule.install', 'Для установки Юпи! на СУБД SQLite, вам потребуется сделать следующее:'); ?></p>
        <p><?php echo Yii::t('InstallModule.install', 'Создаём файл базы данных:'); ?></p>
        <pre>sqlite3 {webroot}/protected/data/yupe.db ""</pre>
        <p><?php echo Yii::t('InstallModule.install', 'Назначить права на файл для пользователя, от имени которого выполняется web-сервер:'); ?></p>
        <pre>sudo chown -hR {user} {webroot}/protected/data/yupe.db</pre>
    </div>

    <?php if (!$data['result']) : ?>
        <div class="alert alert-block alert-error">
            <b><?php echo Yii::t('InstallModule.install', "Файл {file} не существует или не доступен для записи!", array('{file}' => $data['file'])); ?></b>
        </div>
    <?php endif; ?>

    <?php echo $form->errorSummary($data['model']); ?>

    <div class="alert alert-block alert-info">
        <p><?php echo '"' . $data['model']->getAttributeLabel('dbType') . '" - ' . Yii::t('InstallModule.install', 'это эксперементальная опция, на данный момент реализована работа лишь с СУБД MySQL и PostgreSQL, остальные СУБД в процессе тестирования.'); ?></p>
    </div>
    <div class="row-fluid control-group <?php echo $data['model']->hasErrors('dbType') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($data['model'], 'dbType', $data['model']->getDbTypeNames(), array('class' => 'popover-help span7', 'data-original-title' => $data['model']->getAttributeLabel('dbType'), 'data-content' => $data['model']->getAttributeDescription('dbType'))); ?>
    </div>

    <div class="row-fluid sqlite-disable mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('host') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'host', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('host'), 'data-content' => $data['model']->getAttributeDescription('host'), 'autocomplete' => 'off')); ?>
    </div>

    <div class="row-fluid sqlite-disable mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('port') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'port', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('port'), 'data-content' => $data['model']->getAttributeDescription('port'))); ?>
    </div>

    <div class="row-fluid sqlite-disable mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('dbName') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'dbName', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('dbName'), 'data-content' => $data['model']->getAttributeDescription('dbName'), 'autocomplete' => 'off')); ?>
    </div>

    <div class="row-fluid sqlite-disable mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('createDb') ? 'error' : ''; ?>">
        <?php echo $form->checkBoxRow($data['model'], 'createDb'); ?>
    </div>

    <div class="row-fluid sqlite-enable mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('tablePrefix') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'tablePrefix', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('tablePrefix'), 'data-content' => $data['model']->getAttributeDescription('tablePrefix'))); ?>
    </div>

    <div class="row-fluid sqlite-disable mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('dbUser') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'dbUser', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('dbUser'), 'data-content' => $data['model']->getAttributeDescription('dbUser'), 'autocomplete' => 'off')); ?>
    </div>

    <div class="row-fluid sqlite-disable mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('dbPassword') ? 'error' : ''; ?>">
        <?php echo $form->passwordFieldRow($data['model'], 'dbPassword', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('dbPassword'), 'data-content' => $data['model']->getAttributeDescription('dbPassword'), 'autocomplete' => 'off')); ?>
    </div>

    <div class="row-fluid sqlite-disable mysql-enable postgresql-enable control-group <?php echo $data['model']->hasErrors('socket') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'socket', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('socket'), 'data-content' => $data['model']->getAttributeDescription('socket') . ' (обязательно только при подключении через сокет)')); ?>
    </div>

    <div class="row-fluid sqlite-enable mysql-disable postgresql-disable control-group <?php echo $data['model']->hasErrors('dbConString') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($data['model'], 'dbConString', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $data['model']->getAttributeLabel('socket'), 'data-content' => $data['model']->getAttributeDescription('socket') . ' (обязательно только при подключении через сокет)')); ?>
    </div>


<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'label' => Yii::t('InstallModule.install', '< Назад'),
        'url'   => array('/install/default/requirements'),
    )
); ?>
&nbsp;
<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('InstallModule.install', 'Проверить подключение и продолжить >'),
    )
); ?>

<?php $this->endWidget(); ?>