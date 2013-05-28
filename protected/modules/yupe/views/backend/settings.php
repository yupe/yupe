<?php
$this->breadcrumbs = array(
    Yii::t('YupeModule.yupe', 'Система') => array('settings'),
    Yii::t('YupeModule.yupe', 'Модули'),
);
?>

<h1><?php echo Yii::t('YupeModule.yupe', 'Настройки модулей'); ?></h1>

<?php echo Yii::t('YupeModule.yupe', 'Настройте модули "{app}" под Ваши потребности', array('{app}' => Yii::app()->name)); ?>

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
        <?php echo Yii::t('YupeModule.yupe', 'Установлено'); ?>
        <small class="label label-info"><?php echo $yupeCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'модуль|модуля|модулей', $yupeCount); ?>,
        <?php echo Yii::t('YupeModule.yupe', 'включено'); ?>
        <small class="label label-info"><?php echo $enableCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'модуль|модуля|модулей', $enableCount); ?>,
        <?php echo Yii::t('YupeModule.yupe', 'выключен|выключено',$yupeCount - $enableCount); ?>
        <small class="label label-info"><?php echo $yupeCount - $enableCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'модуль|модуля|модулей', $yupeCount - $enableCount); ?>
        <br/>
        <small>
            <?php echo Yii::t('YupeModule.yupe', '( дополнительные модули всегда можно поискать на {link} или {order_link} )', array(
                '{link}'       => CHtml::link(Yii::t('YupeModule.yupe', 'официальном сайте'), 'http://yupe.ru/?from=mlist', array('target' => '_blank')),
                '{order_link}' => CHtml::link(Yii::t('YupeModule.yupe', 'заказать их разработку'), 'http://yupe.ru/feedback/index/?from=mlist', array('target' => '_blank')),
            )); ?>
        </small>
    </p>
</div>

<?php echo $this->renderPartial('_moduleslist', array('modules' => $modules)); ?>