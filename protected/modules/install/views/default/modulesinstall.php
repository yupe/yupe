<?php
/**
 * Отображение для modulesinstall:
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
        'id'                     => 'modulesinstall-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
    ]
);

Yii::app()->clientScript->registerScript(
    'tooltip',
    "jQuery('body').tooltip({'selector':'[rel=tooltip]'});",
    CClientScript::POS_READY
);

?>

<?php $this->widget('install.widgets.GetHelpWidget'); ?>

<div class="alert alert-info">
    <p><?= Yii::t('InstallModule.install', 'Please check modules you want to be installed.'); ?></p>

    <p><?= Yii::t(
            'InstallModule.install',
            'Addition modules you can install/activate from control panel.'
        ); ?></p>
</div>

<div class="alert alert-success">
    <?php
    echo Yii::t(
        'InstallModule.install',
        'Summary modules: {all}, checked for install: {checked}',
        [
            '{all}'     => '<small class="label label-info">' . count($data['modules']) . '</small>',
            '{checked}' => '<small class="label label-info checked-count">0</small>',
        ]
    ); ?>
</div>

<?php
$this->widget(
    'bootstrap.widgets.TbButtonGroup',
    [
        'context'     => 'info',
        'buttons'     => [
            [
                'label'       => Yii::t('InstallModule.install', 'Store'),
                'url'         => '#',
                'htmlOptions' => ['id' => 'store-check']
            ],
            [
                'label'       => Yii::t('InstallModule.install', 'Only basic modules'),
                'url'         => '#',
                'htmlOptions' => ['id' => 'basic-check']
            ],
            [
                'label'       => Yii::t('InstallModule.install', 'All'),
                'url'         => '#',
                'htmlOptions' => ['id' => 'all-check']
            ],
        ],
        'htmlOptions' => ['style' => 'margin: 0;'],
    ]
); ?>

<table id="module-list" class="table table-striped">
    <thead>
    <tr>
        <th></th>
        <th></th>
        <th style="width: 32px;"><?= Yii::t('InstallModule.install', 'Version'); ?></th>
        <th style="width: 32px;"></th>
        <th style="width: 150px;"><?= Yii::t('InstallModule.install', 'Name'); ?></th>
        <th><?= Yii::t('InstallModule.install', 'Description'); ?></th>
        <th><?= Yii::t('InstallModule.install', 'Dependencies'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $post = Yii::app()->getRequest()->getIsPostRequest();
    $modulesSelection = [
        'all'   => [],
        'recom' => [],
        'basic' => [],
        'store' => []
    ];
    $storeModules = [
        'store',
        'order',
        'payment',
        'cart',
        'coupon',
        'delivery',
        'robokassa',
        'yandexmarket',
        'mail',
        'comment',
        'menu',
        'image',
        'category',
        'callback',
        'favorite',
        'yandexmoney'
    ];
    foreach ($data['modules'] as $module) : {
        if (!is_object($module)) {
            continue;
        }
        $modulesSelection['all'][] = '#module_' . $module->getId();
        if ($module->getIsInstallDefault()) {
            $modulesSelection['recom'][] = '#module_' . $module->getId();
        }
        if ($module->getIsNoDisable()) {
            $modulesSelection['basic'][] = '#module_' . $module->getId();
        }
        if(in_array($module->getId(), $storeModules)) {
            $modulesSelection['store'][] = '#module_' . $module->getId();
        }
        ?>
        <tr>
            <td>
                <?= CHtml::checkBox(
                    'module_' . $module->getId(),
                    ($post && !$module->getIsNoDisable())
                        ? (isset($_POST['module_' . $module->getId()]) && $_POST['module_' . $module->getId()])
                        : ($module->getIsInstallDefault() ? true : false),
                    $module->getIsNoDisable()
                        ? ['onclick' => 'this.checked=true']
                        : []
                ); ?>
            </td>
            <td><?=($module->icon ? ("<i class='" . $module->icon . "'>&nbsp;</i> ") : ""); ?></td>
            <td>
                <small class='label label-info'> <?= $module->version; ?></small>
            </td>
            <td>
                <?php if ($module->isMultiLang()) : { ?>
                    <i class="fa fa-fw fa-globe"
                       title="<?= Yii::t('InstallModule.install', 'Multilanguage module'); ?>"></i>
                <?php } endif; ?>
            </td>
            <td>
                <small class="text-muted"><?= $module->category; ?></small>
                <br/>
                <span><?= $module->name; ?></span>
            </td>
            <td style="font-size: 90%;">
                <p><?= $module->description; ?></p>

                <p class="small">
                    <b><?= Yii::t('InstallModule.install', 'Author:'); ?></b> <?= $module->author; ?> (<?= CHtml::link($module->authorEmail, 'mailto:' . $module->authorEmail) ?>)
                    <b><?= Yii::t('InstallModule.install', 'Module site:'); ?></b> <?= CHtml::link($module->url, $module->url); ?>
                </p>
            </td>
            <td class="check-label" style="font-size: 13px;">
                <?php
                $tabs = [];

                if ($module->getId() != 'yupe' && count($module->getDependencies())) {
                    $deps = $module->getDependencies();
                    foreach ($deps as &$dep) {
                        $dep = $data['modules'][$dep]->name;
                    }
                    $tabs[] = [
                        'label'   => Yii::t('InstallModule.install', 'Depends from'),
                        'content' => implode(', ', $deps),
                        'count'   => count($deps),
                    ];
                }
                if ($module->getId() == 'yupe') {
                    $tabs[] = [
                        'label'   => Yii::t('InstallModule.install', 'Dependent'),
                        'content' => Yii::t('InstallModule.install', 'All modules'),
                        'count'   => Yii::t('InstallModule.install', 'All'),
                    ];
                } else {
                    if (count($deps = $module->getDependent())) {
                        foreach ($deps as &$dep) {
                            $dep = $data['modules'][$dep]->name;
                        }
                        $tabs[] = [
                            'label'   => Yii::t('InstallModule.install', 'Dependent'),
                            'content' => implode(', ', $deps),
                            'count'   => count($deps),
                        ];
                    }
                }
                foreach ($tabs as $t) {
                    echo $t['label'] . " " . CHtml::tag(
                            'span',
                            [
                                'class' => 'badge alert-info',
                                'rel'   => 'tooltip',
                                'title' => $t['content'],
                            ],
                            CHtml::tag('small', [], $t['count'])
                        ) . '</br>';
                }
                ?>
                <br/>

                <?= $module->getIsNoDisable()
                    ? '<span class="badge alert-warning" style="font-size: 11px;">' . Yii::t(
                        'InstallModule.install',
                        'System module. (Can\'t disable)'
                    ) . '</span>'
                    : ''
                ?>
            </td>
        </tr>
    <?php } endforeach; ?>
    </tbody>
</table>

<?php
$dependencies = $module->getDependenciesAll();
$dependents = $module->getDependents();
$keyDependencies = implode(', #module_', array_keys(
    CMap::mergeArray($dependencies, $dependents)
));

$jsArray = CJavaScript::encode($dependencies);
$jsArrayRevert = CJavaScript::encode($dependents);
$jsArrayNoDisable = CJavaScript::encode($module->getModulesNoDisable());

$modulesSelection['recom'] = implode(', ', $modulesSelection['recom']);
$modulesSelection['all'] = implode(', ', $modulesSelection['all']);
$modulesSelection['basic'] = implode(', ', $modulesSelection['basic']);
$modulesSelection['store'] = implode(', ', $modulesSelection['store']);

$js = <<<EOF
    var array          = {$jsArray},
        arrayRevert    = {$jsArrayRevert},
        arrayNoDisable = {$jsArrayNoDisable};

    checkedCount();

    $.each(arrayRevert, function (i, val) {
        if ($.inArray(i, arrayNoDisable) == -1) {
            $.each(val, function (iRevert, valRevert) {
                if ($('#module_' + valRevert).is(':checked')) {
                    $('#module_' + i).prop('checked', true);
                    $('#module_' + i).parent().siblings('.check-label').find('.dependents').show();

                    return false;
                }
            });
        }
    });

    $(document).on('change', '#module_{$keyDependencies}', function () {
        checkedCount();
        var id = $(this).attr('id').replace('module_', '');

        if ($(this).is(':checked')) {
            enableModule(id);
        } else {
            disableModule(id);
        }
    });

    $(document).on('click', '#recom-check, #all-check, #basic-check, #store-check', function () {
        $("{$modulesSelection['all']}").prop('checked', false);
        switch ($(this).attr('id')) {
            case 'recom-check':
                $("{$modulesSelection['recom']}").prop('checked', true);
                $('{$modulesSelection['recom']}').change();
                break;
            case 'all-check':
                $("{$modulesSelection['all']}").prop('checked', true);
                break;
            case 'store-check':
                $("{$modulesSelection['basic']}").prop('checked', true);
                $("{$modulesSelection['store']}").prop('checked', true);
                $('#module_{$keyDependencies}').change();
                break;
            case 'basic-check':
                $("{$modulesSelection['basic']}").prop('checked', true);
                $('{$modulesSelection['basic']}').change();
                break;
        }
        checkedCount();
    });

    $(document).on('show.bs.modal', '#modules-modal', function () {
        $('#modules-modal-list').find("i").each(function () {
            $(this).removeClass("fa fa-fw fa-check").addClass("fa fa-fw fa-minus");
        });
        $('#module-list').find("input:checked").each(function () {
            var id = $(this).attr('id').replace('module_', 'modal_');
            $('#' + id + ' i').removeClass("fa fa-fw fa-minus").addClass("fa fa-fw fa-check");
        });
    });

    $(document).on('click', '#modal-confirm', function () {
        $('#modulesinstall-form').submit();
    });

    function checkedCount()
    {
        $('.checked-count').text($('#module-list').find("input:checked").length);
    }

    function enableModule(id)
    {
        moduleManager(id, array, true);
    }

    function disableModule(id)
    {
        moduleManager(id, arrayRevert, false);
    }

    /**
    * Управление модулем и зависимостями
    *
    * @param {string} id
    * @param {object) deps Массив с зависимостями модуля для включения или отключения
    * @param {boolean} flag Вкл/выкл модуль
    */
    function moduleManager(id, deps, flag)
    {
        if ($.inArray(id, arrayNoDisable) !== -1) {
            return false;
        }

        if (id in deps) {
            $.each(deps[id], function (i, val) {
                $('#module_' + val).prop('checked', flag);
                $('#module_' + val).change();
            });
        } else {
            $('#module_' + id).prop('checked', flag);
        }
    }
EOF;
Yii::app()->clientScript->registerScript(__CLASS__ . '#dependencies', $js, CClientScript::POS_END);
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', ['id' => 'modules-modal']); ?>
<div class="modal-header">
    <h4>
        <?= Yii::t(
            'InstallModule.install',
            'Will be installed <small class="label label-info checked-count">0</small> modules. Do you want to continue?'
        ); ?>
    </h4>
</div>
<div id="modules-modal-list" class="modal-body row">
    <div class="col-xs-6">
        <?php
        $moduleCountTr = ceil(count($data['modules']) / 2);
        $i = 0;
        foreach ($data['modules'] as $module) {
            if ($moduleCountTr == $i) {
                echo '</div><div class="col-xs-6">';
            }
            echo '<div id="modal_' . $module->getId(
                ) . '"><i class="fa fa-fw fa-minus"> </i> ' . $module->name . '</div>';
            $i++;
        }
        ?>
    </div>
</div>
<div class="modal-footer">
    <?= CHtml::link(
        Yii::t('InstallModule.install', 'Cancel'),
        '#',
        ['class' => 'btn btn-default', 'data-dismiss' => 'modal']
    ); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'buttonType'  => 'submit',
            'context'     => 'primary',
            'label'       => Yii::t('InstallModule.install', 'Continue >'),
            'htmlOptions' => [
                'data-dismiss' => 'modal',
                'id'           => 'modal-confirm'
            ],
        ]
    ); ?>
</div>
<?php $this->endWidget(); ?>

<br/>

<?= CHtml::link(
    Yii::t('InstallModule.install', '< Back'),
    ['/install/default/dbsettings'],
    ['class' => 'btn btn-default']
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'context'     => 'primary',
        'label'       => Yii::t('InstallModule.install', 'Continue >'),
        'htmlOptions' => [
            'data-toggle' => 'modal',
            'data-target' => '#modules-modal',
        ],
    ]
); ?>

<?php $this->endWidget(); ?>
