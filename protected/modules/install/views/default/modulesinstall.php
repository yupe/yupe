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
    <table class="table table-striped table-vmiddle">
        <thead>
        <tr>
            <th></th>
            <th></th>
            <th style="width: 32px;"><?php echo Yii::t('yupe', 'Версия'); ?></th>
            <th style="width: 32px;"></th>
            <th style="width: 150px;"><?php echo Yii::t('yupe', 'Название'); ?></th>
            <th><?php echo Yii::t('yupe', 'Описание'); ?></th>
        </tr>
        </thead>
        <tbody>
            <?php
            $post = Yii::app()->request->isPostRequest;

            foreach ($modules as $module): ?>
                <tr>
                    <td><?php echo CHtml::checkBox(
                        'module_' . $module->id,
                        ($post && !$module->isNoDisable )?(isset($_POST['module_' . $module->id]) && $_POST['module_' . $module->id]): ($module->isInstallDefault ? true : false),
                        $module->isNoDisable ? array('disabled' => true) : array()
                    ); ?></td>
                    <td><?php echo ($module->icon ? ("<i class='icon-" . $module->icon . "'>&nbsp;</i> ") : ""); ?></td>
                    <td>
                        <small class='label <?php
                            $v = $module->version;
                            echo (($n = strpos($v, "(dev)")) !== FALSE)
                                ? "label-warning' title='" . Yii::t('yupe', 'Модуль в разработке') . "'>" . substr($v, 0, $n)
                                : "'>" . $v;
                        ?></small>
                    </td>
                    <td>
                        <?php if ($module->isMultiLang()): ?>
                            <i class="icon-globe" title="<?php echo Yii::t('yupe', 'Модуль мультиязычный'); ?>"></i>
                        <?php endif; ?>
                    </td>
                    <td>
                        <small style="font-size: 80%;"><?php echo $module->category; ?></small><br />
                        <span><?php echo $module->name; ?></span>
                    </td>
                    <td>
                        <?php echo $module->description; ?>
                        <br />
                        <small style="font-size: 80%;"> <?php echo "<b>" . Yii::t('yupe', "Автор:") . "</b> " . $module->author; ?>
                        (<a href="mailto:<?php echo $module->authorEmail; ?>"><?php echo $module->authorEmail; ?></a>) &nbsp;
                        <?php echo "<br/><b>" . Yii::t('yupe', 'Сайт модуля:') . "</b> " . CHtml::link($module->url, $module->url); ?></small><br />
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('install', '< Назад'),
        'url'   => array('/install/default/dbsettings'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('install', 'Продолжить >'),
    )); ?>

<?php $this->endWidget(); ?>