<?php
/**
 * Отображение для backend/_moduleslist:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
if (count($modules)) :
    $on = $off = $has = $dis = array();
    $updates = Yii::app()->migrator->checkForUpdates($modules);

    foreach ($modules as &$m) {

        if ($m->canActivate() === false)
            continue;

        if ($m->getIsActive() || $m->getIsNoDisable()) {
            $on[$m->id] = $m;
            if (isset($updates[$m->id]))
                $has[$m->id] = $m;
        } else if ($m->getIsInstalled()) {
            $off[$m->id] = $m;
        } else {
            $dis[$m->id] = $m;
        }
    } ?>
    <div class="page-header">
    <h6>
        <?php
        echo Yii::t(
            'YupeModule.yupe', 'Модули разработанные специально для "{app}"', array(
                '{app}' => CHtml::encode(Yii::t('YupeModule.yupe', Yii::app()->name)),
            )
        ); ?>
    </h6>
    </div>
    <?php
    $tabs = array();

    if (count($on))
        $tabs[] = array(
            'label'   => Yii::t('YupeModule.yupe', 'Активные') . "&nbsp;" . CHtml::tag('span', array('class' => 'label label-success flash'), CHtml::tag('small', array(), count($on))),
            'content' => modulesTable($on, $updates, $modules, $this),
            'active'  => true
        );
    if (count($has))
        $tabs[] = array(
            'label'   => Yii::t('YupeModule.yupe', 'Есть обновления') . "&nbsp;" . CHtml::tag('span', array('class' => 'label label-waring'), CHtml::tag('small', array(), count($has))),
            'content' => modulesTable($has, $updates, $modules, $this)
        );
    if (count($off))
        $tabs[] = array(
            'label'   => Yii::t('YupeModule.yupe', 'Отключенные') . "&nbsp;" . CHtml::tag('span', array('class' => 'label'), CHtml::tag('small', array(), count($off))),
            'content' => modulesTable($off, $updates, $modules, $this)
        );
    if (count($dis))
        $tabs[] = array(
            'label'   => Yii::t('YupeModule.yupe', 'Не устанновленные') . "&nbsp;" . CHtml::tag('span', array('class' => 'label'), CHtml::tag('small', array(), count($dis))),
            'content' => modulesTable($dis, $updates, $modules, $this)
        );

    $tabs[0]['active'] = true;

    $this->widget(
        'bootstrap.widgets.TbTabs', array(
            'type'        => 'tabs', // 'tabs' or 'pills'
            'tabs'        => $tabs,
            'encodeLabel' => false,
        )
    );
endif;


function moduleRow($module, &$updates, &$modules)
{
?>
    <tr class="<?php echo ($module->getIsActive()) ? (is_array($module->checkSelf()) ? 'error' : '') : 'muted';?>">
        <td><?php echo $module->icon ? "<i class='icon-" . $module->getIcon() . "'>&nbsp;</i> " : ""; ?></td>
        <td>
            <small class='label'><?php echo $module->getVersion();?></small>
        </td>
        <td>
            <?php if ($module->isMultiLang()) : ?>
                <i class="icon-globe" title="<?php echo Yii::t('YupeModule.yupe', 'Модуль мультиязычный'); ?>"></i>
            <?php endif; ?>
        </td>
        <td>
            <small style="font-size: 80%;"><?php echo Yii::t('YupeModule.yupe', $module->getCategory()); ?></small><br />
            <?php if ($module->getIsActive() || $module->getIsNoDisable()): ?>
                <?php echo CHtml::link($module->getName() . ' <small>(' . $module->getId() . ')</small>', $module->getAdminPageLinkNormalize()); ?>
            <?php else: ?>
                <span><?php echo $module->getName() . ' <small>(' . $module->getId() . ')</small>'; ?></span>
            <?php endif; ?>
        </td>
        <td>
            <?php echo $module->description; ?>
            <br />
            <small style="font-size: 80%;"> <?php echo "<b>" . Yii::t('YupeModule.yupe', "Автор:") . "</b> " . $module->getAuthor(); ?>
            (<a href="mailto:<?php echo $module->getAuthorEmail(); ?>"><?php echo $module->getAuthorEmail(); ?></a>) &nbsp;
            <?php echo "<b>" . Yii::t('YupeModule.yupe', 'Сайт модуля:') . "</b> " . CHtml::link($module->getUrl(), $module->getUrl()); ?></small><br />
        </td>
        <td style="font-size: 10px;">
            <?php
                $tabs = array();

                if ($module->getId() != 'yupe' && count($module->getDependencies()))
                {
                    $deps = $module->getDependencies();
                    foreach($deps as &$dep)
                        $dep = $modules[$dep]->getName();
                    $tabs[] = array(
                        'label'   => Yii::t('YupeModule.yupe', 'Зависит от'),
                        'content' => implode(', ', $deps),
                        'count'   => count($deps),
                    );
                }
                if( $module->getId() == 'yupe')
                    $tabs[] = array(
                        'label'   => Yii::t('YupeModule.yupe', 'Зависимые'),
                        'content' => Yii::t('YupeModule.yupe', 'Все модули'),
                        'count'   => Yii::t('YupeModule.yupe', 'Все'),
                    );
                else
                    if(count($deps = $module->getDependent()))
                    {
                        foreach($deps as &$dep)
                            $dep = $modules[$dep]->getName();
                        $tabs[] = array(
                            'label'   => Yii::t('YupeModule.yupe', 'Зависимые'),
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
        </td>
        <td>
            <?php if ($module->getIsActive() && $module->getEditableParams()): ?>
                <?php echo CHtml::link('<i class="icon-wrench" rel="tooltip" title="' . Yii::t('YupeModule.yupe', 'Настройки') . '">&nbsp;</i>', array(
                    '/yupe/backend/modulesettings/',
                    'module' => $module->getId(),
                )); ?>
            <?php endif; ?>
            <?php
                $url = array('/yupe/backend/modulechange/', 'name' => $module->getId());
                $htmlOptions = array(
                    'class'  => 'changeStatus',
                    'module' => $module->getId(),
                );

                echo $module->getIsNoDisable() ? '' :
                    ($module->getIsInstalled() || $module->getIsActive()
                        ? ($module->getIsActive()
                            ? CHtml::link('<i class="icon-minus-sign" rel="tooltip" title="' . Yii::t('YupeModule.yupe', 'Выключить') . '">&nbsp;</i>', $url + array('status' => '0'), array_merge($htmlOptions, array('status' => 0, 'method' => 'deactivate')))
                            : CHtml::link('<i class="icon-ok-sign" rel="tooltip" title="' . Yii::t('YupeModule.yupe', 'Включить') . '">&nbsp;</i>', $url + array('status' => '1'), array_merge($htmlOptions, array('status' => 1, 'method' => 'activate'))) .
                                ($module->isNeedUninstall()
                                    ? ''
                                    : CHtml::link('<i class="icon-remove" rel="tooltip" title="' . Yii::t('YupeModule.yupe', 'Деинсталлировать') . '">&nbsp;</i>', $url + array('status' => '0'), array_merge($htmlOptions, array('status' => 0, 'method' => 'uninstall')))
                                )
                        )
                        : CHtml::link('<i class="icon-download-alt" rel="tooltip" title="' . Yii::t('YupeModule.yupe', 'Установить') . '">&nbsp;</i>', $url + array('status' => '1'), array_merge($htmlOptions, array('status' => 1, 'method' => 'install')))
                    );

                if (isset($updates[$module->getId()]) && $module->getIsInstalled())
                    echo CHtml::link('<i class="icon-refresh" rel="tooltip" title="' . Yii::t('YupeModule.yupe', 'Есть {n} обновление базы!|Есть {n} обновления базы!|Есть {n} обновлений базы!', count($updates[$module->getId()])) . '">&nbsp;</i>', array('/yupe/backend/modupdate', 'name' => $module->getId()));
                if ($module->getIsActive() && $module->isConfigNeedUpdate())
                    echo CHtml::link('<i class="icon-repeat" rel="tooltip" title="' . Yii::t('YupeModule.yupe', 'Есть обновление файла конфигурации!') . '">&nbsp;</i>', $url + array('status' => '2'), array_merge($htmlOptions, array('status' => 2, 'method' => 'update')));
                ?>
        </td>
    </tr>
<?php
}

function modulesTable($modules, &$updates, &$allmodules,&$controller)
{
    ob_start();
    ob_implicit_flush(false);
?>
    <table class="table table-striped table-vmiddle">
        <thead>
        <tr>
            <th></th>
            <th style="width: 32px;"><?php echo Yii::t('YupeModule.yupe', 'Версия'); ?></th>
            <th style="width: 32px;"></th>
            <th style="width: 150px;"><?php echo Yii::t('YupeModule.yupe', 'Название'); ?></th>
            <th><?php echo Yii::t('YupeModule.yupe', 'Описание'); ?></th>
            <th><?php echo Yii::t('YupeModule.yupe', 'Зависимости'); ?></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <?php
            foreach ($modules as $module)
                moduleRow($module, $updates, $allmodules, $controller);
            ?>
        </tbody>
    </table>
<?php
    return ob_get_clean();
}
?>