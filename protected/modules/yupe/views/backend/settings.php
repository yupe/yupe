<?php
$this->breadcrumbs = array(
    Yii::t('yupe', 'Система') => array('settings'),
    Yii::t('yupe', 'Настройки модулей'),
);
?>

<h1><?php echo Yii::t('yupe', 'Настройки модулей'); ?></h1>

<?php echo Yii::t('yupe', 'Настройте модули "{app}" под Ваши потребности', array('{app}' => Yii::app()->name)); ?>

<br/><br/>

<p>
    <?php echo Yii::t('yupe', 'Установлено');?>
    <small class="label label-info"><?php echo $mn = count($modules); ?></small>
    <?php echo Yii::t('yupe', 'модуль|модуля|модулей', $mn); ?>
    <small>
        <?php echo Yii::t('yupe', '( дополнительные модули всегда можно поискать на {link} или {order_link} )', array(
            '{link}'       => CHtml::link(Yii::t('yupe', 'официальном сайте'), 'http://yupe.ru/?from=mlist', array('target' => '_blank')),
            '{order_link}' => CHtml::link(Yii::t('yupe', 'заказать их разработку'), 'http://yupe.ru/feedback/contact/?from=mlist', array('target' => '_blank')),
        )); ?>
    </small>
</p>

<?php echo $this->renderPartial('_moduleslist', array('modules' => $modules)); ?>