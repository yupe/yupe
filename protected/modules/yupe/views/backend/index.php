<div class="page-header">
    <h1><?php echo Yii::t('YupeModule.yupe', 'Панель управления "{app}"', array('{app}' => CHtml::encode(Yii::t('YupeModule.yupe', Yii::app()->name)))); ?><br/>
    <small><?php echo Yii::t('YupeModule.yupe', '{nick_name}, добро пожаловать в панель управления Вашим сайтом!',array(
        '{nick_name}' => Yii::app()->user->getState('nick_name')
        )); ?></small></h1>
</div>

<div class="alert">
    <p>
        <?php echo Yii::t('YupeModule.yupe','Вы используете Yii версии'); ?>
        <small class="label label-info" title="<?php echo Yii::getVersion(); ?>"><?php echo Yii::getVersion(); ?></small>,
        <?php echo CHtml::encode(Yii::app()->name); ?>
        <?php echo Yii::t('YupeModule.yupe', 'версии'); ?> <small class="label label-info" title="<?php echo Yii::app()->getModule('yupe')->version; ?>"><?php echo Yii::app()->getModule('yupe')->version; ?></small>,
        <?php echo Yii::t('YupeModule.yupe', 'php версии'); ?>
        <small class="label label-info" title="<?php echo phpversion(); ?>"><?php echo phpversion(); ?></small>
    </p>
    </br>
    <p>
        <?php
            $yiiCount    = count($yiiModules);
            $yupeCount   = count($modules);
            $allCount    = $yupeCount + $yiiCount;
            $enableCount = 0;
            foreach ($modules as $module) {
                if ($module->isActive || $module->isNoDisable)
                    $enableCount++;
            }
        ?>
        <?php echo Yii::t('YupeModule.yupe', 'Установлено'); ?>
        <small class="label label-info"><?php echo $allCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'модуль|модуля|модулей', $allCount); ?>
        (<?php echo Yii::t('YupeModule.yupe', 'включено'); ?>
        <small class="label label-info"><?php echo $enableCount + $yiiCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'модуль|модуля|модулей', $enableCount + $yiiCount); ?>,
        <?php echo Yii::t('YupeModule.yupe', 'выключено'); ?>
        <small class="label label-info"><?php echo $yupeCount - $enableCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'модуль|модуля|модулей', $yupeCount - $enableCount); ?>)
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
        'shortcuts' => $modulesNavigation
    )
); ?>

<?php $this->menu = $modulesNavigation; ?>