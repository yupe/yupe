<?php
$this->breadcrumbs = array(
    Yii::t('YupeModule.engine', 'Система') => array('settings'),
    Yii::t('YupeModule.engine', 'Настройки') => array('settings'),
    Yii::t('YupeModule.engine', 'Темы оформления'),
);
?>

<h1><?php echo Yii::t('YupeModule.engine', 'Выбор темы оформления');?></h1>

<div class="alert alert-block alert-info">
    <?php echo Yii::t('YupeModule.engine', 'Текущая тема'); ?>: <b><?php echo $theme; ?></b>,
    <?php echo Yii::t('YupeModule.engine', 'Текущая тема административной части'); ?>: <b><?php echo $backendTheme; ?></b>
    <p><?php echo CHtml::link(Yii::t('YupeModule.engine', 'Подробнее про темы оформления'),'http://yiiframework.ru/doc/guide/ru/topics.theming',array('target' => '_blank'));?></p>
</div>

<?php echo CHtml::beginForm(array('/engine/backend/themesettings', 'post'), 'post', array('class' => 'well')); ?>
    <?php echo CHtml::label(Yii::t('YupeModule.engine', 'Выберите тему сайта'), 'theme');?>
    <?php echo CHtml::dropDownList('theme', $theme, $themes, array('class' => 'span5'));?>
    <br />
    <?php echo CHtml::label(Yii::t('YupeModule.engine', 'Выберите тему административной части'), 'backendTheme');?>
    <?php echo CHtml::dropDownList('backendTheme', $backendTheme, $backendThemes, array('class' => 'span5', 'empty' => Yii::t('YupeModule.engine', 'Тема не используется')));?>
    <br /><br />
    <?php echo CHtml::submitButton(Yii::t('YupeModule.engine', 'Сохранить настройки тем оформления'),array('class' => 'btn btn-primary'));?>

<?php echo CHtml::endForm();?>