<?php
$this->breadcrumbs = array(
    Yii::t('YupeModule.engine', 'Система') => array('settings'),
    Yii::t('YupeModule.engine', 'Модули'),
);
?>

<h1><?php echo Yii::t('YupeModule.engine', 'Настройки модулей'); ?></h1>

<?php echo Yii::t('YupeModule.engine', 'Настройте модули "{app}" под Ваши потребности', array('{app}' => Yii::app()->name)); ?>

<br/><br/>
<div class="alert">
    <p>
        <?php
            $yupeCount = count($modules);
            $enableCount = 0;
            foreach ($modules as $module) {
                if ($module->getIsActive() || $module->getIsNoDisable())
                    $enableCount++;
            }
        ?>
        <?php echo Yii::t('YupeModule.engine', 'Установлено'); ?>
        <small class="label label-info"><?php echo $yupeCount; ?></small>
        <?php echo Yii::t('YupeModule.engine', 'модуль|модуля|модулей', $yupeCount); ?>,
        <?php echo Yii::t('YupeModule.engine', 'включено'); ?>
        <small class="label label-info"><?php echo $enableCount; ?></small>
        <?php echo Yii::t('YupeModule.engine', 'модуль|модуля|модулей', $enableCount); ?>,
        <?php echo Yii::t('YupeModule.engine', 'выключен|выключено',$yupeCount - $enableCount); ?>
        <small class="label label-info"><?php echo $yupeCount - $enableCount; ?></small>
        <?php echo Yii::t('YupeModule.engine', 'модуль|модуля|модулей', $yupeCount - $enableCount); ?>
        <br/>
        <small>
            <?php echo Yii::t('YupeModule.engine', '( дополнительные модули всегда можно поискать на {link} или {order_link} )', array(
                '{link}'       => CHtml::link(Yii::t('YupeModule.engine', 'официальном сайте'), 'http://engine.ru/?from=mlist', array('target' => '_blank')),
                '{order_link}' => CHtml::link(Yii::t('YupeModule.engine', 'заказать их разработку'), 'http://engine.ru/feedback/index/?from=mlist', array('target' => '_blank')),
            )); ?>
        </small>
    </p>
</div>

<?php echo $this->renderPartial('_moduleslist', array('modules' => $modules)); ?>