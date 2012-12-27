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
            <th style="width: 32px;"><?php echo Yii::t('install', 'Версия'); ?></th>
            <th style="width: 32px;"></th>
            <th style="width: 150px;"><?php echo Yii::t('install', 'Название'); ?></th>
            <th><?php echo Yii::t('install', 'Описание'); ?></th>
            <th><?php echo Yii::t('install', 'Зависимости'); ?></th>
        </tr>
        </thead>
        <tbody>
            <?php
            $post = Yii::app()->request->isPostRequest;
            foreach ($modules as $module): ?>
                <tr>
                    <td>
                        <?php echo CHtml::checkBox('module_' . $module->id,
                            ($post && !$module->isNoDisable )
                                ? (isset($_POST['module_' . $module->id]) && $_POST['module_' . $module->id])
                                : ($module->isInstallDefault ? true : false),
                            $module->isNoDisable
                                ? array('onclick' => 'this.checked=true', 'class' => 'error')
                                : array()
                        ); ?>
                    </td>
                    <td><?php echo ($module->icon ? ("<i class='icon-" . $module->icon . "'>&nbsp;</i> ") : ""); ?></td>
                    <td>
                        <small class='label <?php
                            $v = $module->version;
                            echo (($n = strpos($v, "(dev)")) !== FALSE)
                                ? "label-warning' title='" . Yii::t('install', 'Модуль в разработке') . "'>" . substr($v, 0, $n)
                                : "'>" . $v;
                        ?></small>
                    </td>
                    <td>
                        <?php if ($module->isMultiLang()): ?>
                            <i class="icon-globe" title="<?php echo Yii::t('install', 'Модуль мультиязычный'); ?>"></i>
                        <?php endif; ?>
                    </td>
                    <td>
                        <small style="font-size: 80%;"><?php echo $module->category; ?></small><br />
                        <span><?php echo $module->name; ?></span>
                    </td>
                    <td>
                        <?php echo $module->description; ?>
                        <br />
                        <small style="font-size: 80%;"> <?php echo "<b>" . Yii::t('install', "Автор:") . "</b> " . $module->author; ?>
                        (<a href="mailto:<?php echo $module->authorEmail; ?>"><?php echo $module->authorEmail; ?></a>) &nbsp;
                        <?php echo " <b>" . Yii::t('install', 'Сайт модуля:') . "</b> " . CHtml::link($module->url, $module->url); ?></small><br />
                    </td>
                    <td class="check-label">
                        <small>
                            <?php echo Yii::t('install', 'Зависит от:') . ' <b>' . (
                                ($module->id != 'yupe' && count($module->dependencies))
                                    ? implode(', ', $module->dependencies)
                                    : '-'
                            ) . '</b>'; ?><br />
                            <?php echo Yii::t('install', 'Зависимые:') . ' <b>' . (
                                ($module->id == 'yupe')
                                    ? Yii::t('install', 'Все модули')
                                    : (count($module->dependent) ? implode(', ', $module->dependent) : '-')
                            ) . '</b>'; ?><br />
                            <?php echo $module->isNoDisable
                                ? '<span class="label label-warning">' . Yii::t('install', "Модуль не отключаемый") . '</span>'
                                : ''
                            ?>
                            <?php echo '<span class="label label-warning dependents" style="display: none;">' . Yii::t('install', "Отключите зависимые, чтобы не устанавливать") . '</span>'; ?>
                        </small>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    $dependencies    = $module->dependenciesAll;
    $keyDependencies = implode(', #module_', array_keys($dependencies));
    $jsArray          = CJavaScript::encode($dependencies);
    $jsArrayRevert    = CJavaScript::encode($module->dependents);
    $jsArrayNoDisable = CJavaScript::encode($module->modulesNoDisable);
    $js = <<<EOF
        var array          = {$jsArray},
            arrayRevert    = {$jsArrayRevert},
            arrayNoDisable = {$jsArrayNoDisable};
        $.each(arrayRevert, function(i, val) {
            if ($.inArray(i, arrayNoDisable) == -1)
            {
                $.each(val, function(iRevert, valRevert) {
                    if ($('#module_' + valRevert).attr('checked')) {
                        $('#module_' + i).attr('onclick', "this.checked=true").attr('readonly', true);
                        $('#module_' + i).parent().siblings('.check-label').find('.dependents').show();
                        return false;
                    }
                });
            }
        });
        $(document).on('change', '#module_{$keyDependencies}', function() {
            var id = $(this).attr('id').replace('module_', '');
            if ($(this).attr('checked')) {
                $.each(array[id], function(i, val) {
                    $('#module_' + val).attr('checked', true).attr('onclick', "this.checked=true");
                });
            } else {
                $.each(array[id], function(i, val) {
                    if ($.inArray(val, arrayNoDisable) == -1) {
                        var all = false;
                        $.each(arrayRevert[val], function(iRevert, valRevert) {
                            if ($('#module_' + valRevert).attr('checked')) {
                                all = true;
                                return false;
                            }
                        });
                        if (!all)
                            $('#module_' + val).attr('onclick', '');
                    }
                });
            }
        });
EOF;
    Yii::app()->clientScript->registerScript(__CLASS__ . '#dependencies', $js, CClientScript::POS_END);
    ?>

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