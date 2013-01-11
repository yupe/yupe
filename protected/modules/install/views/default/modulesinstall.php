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

    <div class="alert alert-block alert-info">
        <p><?php echo Yii::t('InstallModule.install', 'Пожалуйста, выберите модули, которые хотите установить.'); ?></p>
        <p><?php echo Yii::t('InstallModule.install', 'Дополнительные модули можно будет установить/активировать через панель управления.'); ?></p>
    </div>

    <table class="table table-striped table-vmiddle">
        <thead>
        <tr>
            <th></th>
            <th></th>
            <th style="width: 32px;"><?php echo Yii::t('InstallModule.install', 'Версия'); ?></th>
            <th style="width: 32px;"></th>
            <th style="width: 150px;"><?php echo Yii::t('InstallModule.install', 'Название'); ?></th>
            <th><?php echo Yii::t('InstallModule.install', 'Описание'); ?></th>
            <th><?php echo Yii::t('InstallModule.install', 'Зависимости'); ?></th>
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
                                ? array('onclick' => 'this.checked=true')
                                : array()
                        ); ?>
                    </td>
                    <td><?php echo ($module->icon ? ("<i class='icon-" . $module->icon . "'>&nbsp;</i> ") : ""); ?></td>
                    <td>
                        <small class='label <?php
                            $v = $module->version;
                            echo (($n = strpos($v, "(dev)")) !== FALSE)
                                ? "label-warning' title='" . Yii::t('InstallModule.install', 'Модуль в разработке') . "'>" . substr($v, 0, $n)
                                : "'>" . $v;
                        ?></small>
                    </td>
                    <td>
                        <?php if ($module->isMultiLang()): ?>
                            <i class="icon-globe" title="<?php echo Yii::t('InstallModule.install', 'Модуль мультиязычный'); ?>"></i>
                        <?php endif; ?>
                    </td>
                    <td>
                        <small style="font-size: 80%;"><?php echo $module->category; ?></small><br />
                        <span><?php echo $module->name; ?></span>
                    </td>
                    <td style="font-size: 80%;">
                        <?php echo $module->description; ?>
                        <br />
                        <small>
                            <b><?php echo Yii::t('InstallModule.install', "Автор:"); ?></b> <?php echo $module->author; ?>
                            (<a href="mailto:<?php echo $module->authorEmail; ?>">
                                <?php echo $module->authorEmail; ?>
                            </a>) 
                            <b><?php echo Yii::t('InstallModule.install', 'Сайт модуля:'); ?></b> 
                            <?php echo CHtml::link($module->url, $module->url); ?>
                        </small><br />
                    </td>
                    <td class="check-label" style="font-size: 10px;">
                        <?php
                            $tabs = array();

                            if ($module->id != 'yupe' && count($module->dependencies))
                            {
                                $deps = $module->dependencies;
                                foreach($deps as &$dep)
                                    $dep = $modules[$dep]->name;
                                $tabs[] = array(
                                    'label'   => Yii::t('InstallModule.install', 'Зависит от'),
                                    'content' => implode(', ', $deps),
                                    'count'   => count($deps),
                                );
                            }
                            if( $module->id == 'yupe')
                                $tabs[] = array(
                                    'label'   => Yii::t('InstallModule.install', 'Зависимые'),
                                    'content' => Yii::t('InstallModule.install', 'Все модули'),
                                    'count'   => Yii::t('InstallModule.install', 'Все'),
                                );
                            else
                                if(count($deps = $module->dependent))
                                {
                                    foreach($deps as &$dep)
                                        $dep = $modules[$dep]->name;
                                    $tabs[] = array(
                                        'label'   => Yii::t('InstallModule.install', 'Зависимые'),
                                        'content' => implode(', ', $deps),
                                        'count'   => count($deps),
                                    );
                                }
                            foreach ($tabs as $t)
                                echo $t['label'] . " " . CHtml::tag('span', array(
                                    'class' => 'label label-info',
                                    'rel'   => 'tooltip',
                                    'title' => $t['content'],
                                ), CHtml::tag('small', array(), $t['count']));
                            ?>
                        <br />

                        <?php echo $module->isNoDisable
                            ? '<span class="label label-warning" style="font-size: 10px;">' . Yii::t('InstallModule.install', 'Модуль не отключаемый') . '</span>'
                            : ''
                        ?>
                        <span class="label label-warning dependents" style="display: none; font-size: 10px;">
                            <?php echo Yii::t('InstallModule.install', 'Отключите зависимые,<br/>чтобы не устанавливать'); ?>
                        </span>
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
                        $('#module_' + i).attr('checked', true).attr('onclick', "this.checked=true");
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
        'label' => Yii::t('InstallModule.install', '< Назад'),
        'url'   => array('/install/default/dbsettings'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('InstallModule.install', 'Продолжить >'),
    )); ?>

<?php $this->endWidget(); ?>