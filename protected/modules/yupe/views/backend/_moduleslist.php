<?php
/**
 * Отображение для backend/_moduleslist:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
if (count($modules)) :
    $on = $off = $has = $dis = [];
    $updates = Yii::app()->migrator->checkForUpdates($modules);

    foreach ($modules as &$m) {
        if ($m instanceof yupe\components\WebModule === false) {
            continue;
        }

        if ($m->canActivate() === false) {
            continue;
        }

        if ($m->getIsActive() || $m->getIsNoDisable()) {
            $on[$m->id] = $m;
            if (isset($updates[$m->id])) {
                $has[$m->id] = $m;
            }
        } elseif ($m->getIsInstalled()) {
            $off[$m->id] = $m;
        } else {
            $dis[$m->id] = $m;
        }
    } ?>

    <?php
    $tabs = [];

    if (count($on)) {
        $tabs[] = [
            'id' => 'mod-active',
            'label'   => Yii::t('YupeModule.yupe', 'Active') . "&nbsp;" . CHtml::tag(
                    'span',
                    ['class' => 'badge alert-success flash'],
                    CHtml::tag('small', [], count($on))
                ),
            'content' => modulesTable($on, $updates, $modules, $this),
            'active'  => true
        ];
    }
    if (count($has)) {
        $tabs[] = [
            'id' => 'mod-updates',
            'label'   => Yii::t('YupeModule.yupe', 'Have updates') . "&nbsp;" . CHtml::tag(
                    'span',
                    ['class' => 'badge alert-warning'],
                    CHtml::tag('small', [], count($has))
                ),
            'content' => modulesTable($has, $updates, $modules, $this)
        ];
    }
    if (count($off)) {
        $tabs[] = [
            'id' => 'mod-disabled',
            'label'   => Yii::t('YupeModule.yupe', 'Disabled') . "&nbsp;" . CHtml::tag(
                    'span',
                    ['class' => 'badge alert-danger'],
                    CHtml::tag('small', [], count($off))
                ),
            'content' => modulesTable($off, $updates, $modules, $this)
        ];
    }
    if (count($dis)) {
        $tabs[] = [
            'id' => 'mod-inactive',
            'label'   => Yii::t('YupeModule.yupe', 'Not installed') . "&nbsp;" . CHtml::tag(
                    'span',
                    ['class' => 'badge'],
                    CHtml::tag('small', [], count($dis))
                ),
            'content' => modulesTable($dis, $updates, $modules, $this)
        ];
    }

    //$tabs[0]['active'] = true;

    $this->widget(
        'bootstrap.widgets.TbTabs',
        [
            'type'        => 'tabs', // 'tabs' or 'pills'
            'tabs'        => $tabs,
            'encodeLabel' => false,
        ]
    );
endif;

function moduleRow($module, &$updates, &$modules)
{
    ?>
    <tr class="<?= ($module->getIsActive()) ? (is_array(
        $module->checkSelf()
    ) ? 'danger' : '') : 'text-muted'; ?>">
        <td><?= $module->icon ? "<i class='" . $module->getIcon() . "'>&nbsp;</i> " : ""; ?></td>
        <td>
            <small style="font-size: 80%;"><?= Yii::t('YupeModule.yupe', $module->getCategory()); ?></small>
            <br/>
            <?php if ($module->getIsActive() || $module->getIsNoDisable()): ?>
                <?= CHtml::link(
                    $module->getName() . ' <small>(' . $module->getId() . ')</small>',
                    $module->getAdminPageLinkNormalize()
                ); ?>
            <?php else: ?>
                <span><?= $module->getName() . ' <small>(' . $module->getId() . ')</small>'; ?></span>
            <?php endif; ?>
        </td>
        <td>
            <small class='label label-info'><?= $module->getVersion(); ?></small>
        </td>
        <td>
            <?php if ($module->isMultiLang()) : ?>
                <i class="fa fa-fw fa-globe"
                   title="<?= Yii::t('YupeModule.yupe', 'Multilanguage module'); ?>"></i>
            <?php endif; ?>
        </td>
        <td>
            <?= $module->description; ?>
            <br/>
            <small style="font-size: 80%;"> <?= "<b>" . Yii::t(
                        'YupeModule.yupe',
                        "Author:"
                    ) . "</b> " . $module->getAuthor(); ?>
                (<a href="mailto:<?= $module->getAuthorEmail(); ?>"><?= $module->getAuthorEmail(); ?></a>)
                &nbsp;
                <?= "<b>" . Yii::t('YupeModule.yupe', 'Module site:') . "</b> " . CHtml::link(
                        $module->getUrl(),
                        $module->getUrl()
                    ); ?></small>
            <br/>
        </td>
        <td>
            <?php
            $tabs = [];

            if ($module->getId() != \yupe\components\ModuleManager::CORE_MODULE && count($module->getDependencies())) {
                $deps = $module->getDependencies();
                $tabs[] = [
                    'label'   => "<small>" . Yii::t('YupeModule.yupe', 'Depends on') . "</small>",
                    'content' => implode(', ', $deps),
                    'count'   => count($deps),
                ];
            }
            if ($module->getId() == \yupe\components\ModuleManager::CORE_MODULE) {
                $tabs[] = [
                    'label'   => "<small>" . Yii::t('YupeModule.yupe', 'Dependent') . "</small>",
                    'content' => Yii::t('YupeModule.yupe', 'All modules'),
                    'count'   => Yii::t('YupeModule.yupe', 'All'),
                ];
            } else {
                if (count($deps = $module->getDependent())) {
                    foreach ($deps as $dep) {
                        if (isset($modules[$dep]) && $modules[$dep] instanceof yupe\components\WebModule === false) {
                            continue;
                        }
                    }
                    $tabs[] = [
                        'label'   => "<br />" . "<small>" . Yii::t('YupeModule.yupe', 'dependent') . "</small>",
                        'content' => implode(', ', $deps),
                        'count'   => count($deps),
                    ];
                }
            }
            foreach ($tabs as $t) {
                echo $t['label'] . " " . CHtml::tag(
                        'span',
                        [
                            'class' => 'label label-info',
                            'rel'   => 'tooltip',
                            'title' => $t['content'],
                        ],
                        CHtml::tag('small', [], $t['count'])
                    );
            }

            ?>
        </td>
        <td class="button-column">
            <?php if ($module->getIsActive() && $module->getEditableParams()): ?>
                <?= CHtml::link(
                    '<i class="fa fa-fw fa-wrench" rel="tooltip" title="' . Yii::t(
                        'YupeModule.yupe',
                        'Settings'
                    ) . '"></i>',
                    $module->getSettingsUrl()
                ); ?>
            <?php endif; ?>
            <?php
            $url = ['/yupe/modulesBackend/moduleStatus/', 'name' => $module->getId()];
            $htmlOptions = [
                'class'  => 'changeStatus',
                'module' => $module->getId(),
            ];

            echo $module->getIsNoDisable() ? '' :
                ($module->getIsInstalled() || $module->getIsActive()
                    ? ($module->getIsActive()
                        ? CHtml::link(
                            '<i class="fa fa-fw fa-minus-circle" rel="tooltip" title="' . Yii::t(
                                'YupeModule.yupe',
                                'Disable'
                            ) . '">&nbsp;</i>',
                            $url + ['status' => '0'],
                            array_merge($htmlOptions, ['status' => 0, 'method' => 'deactivate'])
                        )
                        : CHtml::link(
                            '<i class="fa fa-fw fa-check-circle" rel="tooltip" title="' . Yii::t(
                                'YupeModule.yupe',
                                'Enable'
                            ) . '">&nbsp;</i>',
                            $url + ['status' => '1'],
                            array_merge($htmlOptions, ['status' => 1, 'method' => 'activate'])
                        ) .
                        ($module->isNeedUninstall()
                            ? ''
                            : CHtml::link(
                                '<i class="fa fa-fw fa-times" rel="tooltip" title="' . Yii::t(
                                    'YupeModule.yupe',
                                    'Uninstall'
                                ) . '">&nbsp;</i>',
                                $url + ['status' => '0'],
                                array_merge($htmlOptions, ['status' => 0, 'method' => 'uninstall'])
                            )
                        )
                    )
                    : CHtml::link(
                        '<i class="fa fa-fw fa-download" rel="tooltip" title="' . Yii::t(
                            'YupeModule.yupe',
                            'Install'
                        ) . '">&nbsp;</i>',
                        $url + ['status' => '1'],
                        array_merge($htmlOptions, ['status' => 1, 'method' => 'install'])
                    )
                );

            if (isset($updates[$module->getId()]) && $module->getIsInstalled()) {
                echo CHtml::link(
                    '<i class="fa fa-fw fa-refresh" rel="tooltip" title="' . Yii::t(
                        'YupeModule.yupe',
                        'Have {n} DB updates!|Have {n} DB updates!|Have {n} DB updates!',
                        count($updates[$module->getId()])
                    ) . '">&nbsp;</i>',
                    ['/yupe/backend/modupdate', 'name' => $module->getId()]
                );
            }
            if ($module->getIsActive() && $module->isConfigNeedUpdate()) {
                echo CHtml::link(
                    '<i class="fa fa-fw fa-repeat" rel="tooltip" title="' . Yii::t(
                        'YupeModule.yupe',
                        'Have configuration file updates!'
                    ) . '">&nbsp;</i>',
                    $url + ['status' => '2'],
                    array_merge($htmlOptions, ['status' => 2, 'method' => 'update'])
                );
            }
            ?>
        </td>
    </tr>
<?php
}

function modulesTable($modules, &$updates, &$allmodules, &$controller)
{
    ob_start();
    ob_implicit_flush(false);
    ?>
    <table class="table table-striped table-vmiddle">
        <thead>
        <tr>
            <th></th>
            <th style="width: 150px;"><?= Yii::t('YupeModule.yupe', 'Name'); ?></th>
            <th style="width: 32px;"><?= Yii::t('YupeModule.yupe', 'Version'); ?></th>
            <th style="width: 32px;"></th>
            <th><?= Yii::t('YupeModule.yupe', 'Description'); ?></th>
            <th><?= Yii::t('YupeModule.yupe', 'Dependencies'); ?></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($modules as $module) {
            moduleRow($module, $updates, $allmodules, $controller);
        }
        ?>
        </tbody>
    </table>
    <?php

    return ob_get_clean();
}

?>
