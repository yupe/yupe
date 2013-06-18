<div class="page-header">
    <h1><?php echo Yii::t('YupeModule.yupe', 'Панель управления "{app}"', array('{app}' => CHtml::encode(Yii::t('YupeModule.yupe', Yii::app()->name)))); ?><br/></h1>
</div>

<?php foreach ($modules as $module): ?>
    <?php if ($module->getIsActive()): ?>
        <?php $messages = $module->checkSelf(); ?>
        <?php if (is_array($messages)): ?>
            <?php foreach ($messages as $key => $value): ?>
                <?php if (!is_array($value)) continue; ?>
                <div class="accordion" id="accordion<?php echo $module->getId(); ?>">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a  class="accordion-toggle"
                                data-toggle="collapse"
                                data-parent="#accordion<?php echo $module->getId(); ?>"
                                href="#collapse<?php echo $module->getId(); ?>"
                                >
                                <?php echo Yii::t('YupeModule.yupe', 'Модуль {icon} "{module}", сообщений: {count}', array(
                                        '{icon}'   => $module->icon ? "<i class='icon-" . $module->icon . "'>&nbsp;</i> " : "",
                                        '{module}' => $module->getName(),
                                        '{count}'  => '<small class="label label-warning">' . count($value) . '</small>',
                                    )); ?>
                            </a>
                        </div>
                        <div id="collapse<?php echo $module->getId(); ?>" class="accordion-body collapse">
                            <?php foreach ($value as $error): ?>
                                <div class="accordion-inner">
                                    <div class="alert alert-<?php echo $error['type']; ?>">
                                        <h4 class="alert-heading">
                                            <?php echo Yii::t('YupeModule.yupe', 'Модуль "{module} ({id})"', array(
                                                    '{module}' => $module->name,
                                                    '{id}'     => $module->getId(),
                                                )); ?>
                                        </h4>
                                        <?php echo $error['message']; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>


<div class="alert">
    <p>
        <?php
        $yiiCount    = count($yiiModules);
        $yupeCount   = count($modules);
        $allCount    = $yupeCount + $yiiCount;
        $enableCount = 0;
        foreach ($modules as $module) {
            if ($module->getIsActive() || $module->getIsNoDisable())
                $enableCount++;
        }
        ?>
        <?php echo Yii::t('YupeModule.yupe', 'Установлено'); ?>
        <small class="label label-info"><?php echo $allCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'модуль|модуля|модулей', $allCount); ?>,
        <?php echo Yii::t('YupeModule.yupe', 'включено'); ?>
        <small class="label label-info"><?php echo $enableCount + $yiiCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'модуль|модуля|модулей', $enableCount + $yiiCount); ?>,
        <?php echo Yii::t('YupeModule.yupe', 'выключен|выключено',$yupeCount - $enableCount); ?>
        <small class="label label-info"><?php echo $yupeCount - $enableCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'модуль|модуля|модулей', $yupeCount - $enableCount); ?>
        <br>
        <small>
            <?php echo Yii::t('YupeModule.yupe', '( дополнительные модули всегда можно поискать на {link} или {order_link} )', array(
                '{link}'       => CHtml::link(Yii::t('YupeModule.yupe', 'официальном сайте'), 'http://yupe.ru/?from=mlist', array('target' => '_blank')),
                '{order_link}' => CHtml::link(Yii::t('YupeModule.yupe', 'заказать их разработку'), 'http://yupe.ru/feedback/index/?from=mlist', array('target' => '_blank')),
            )); ?>
        </small>
    </p>
</div>

<legend><?php echo Yii::t('YupeModule.yupe', 'Быстрый доступ к модулям'); ?></legend>
<?php
$this->widget(
    'yupe.widgets.YShortCuts', array(
        'shortcuts' => $modulesNavigation,
        'modules'   => $modules,
        'updates'   => Yii::app()->migrator->checkForUpdates($modules),
    )
); ?>
<?php $this->menu = $modulesNavigation; ?>