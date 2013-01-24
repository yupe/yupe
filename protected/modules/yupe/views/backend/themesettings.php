<?php
$this->breadcrumbs = array(
    Yii::t('YupeModule.yupe', 'Система') => array('settings'),
    Yii::t('YupeModule.yupe', 'Настройки') => array('settings'),
    Yii::t('YupeModule.yupe', 'Темы оформления'),
);
?>

<h1><?php echo Yii::t('YupeModule.yupe', 'Выбор темы оформления');?></h1>

<div class="alert alert-block alert-info">
    <?php echo Yii::t('YupeModule.yupe', 'Текущая тема'); ?>: <b><?php echo $theme; ?></b>,
    <?php echo Yii::t('YupeModule.yupe', 'Текущая тема административной части'); ?>: <b><?php echo $backendTheme; ?></b>
    <p><?php echo CHtml::link(Yii::t('YupeModule.yupe', 'Подробнее про темы оформления'),'http://yiiframework.ru/doc/guide/ru/topics.theming',array('target' => '_blank'));?></p>
</div>

<?php echo CHtml::beginForm(array('/yupe/backend/themesettings', 'post'), 'post', array('class' => 'well')); ?>
    <?php echo CHtml::label(Yii::t('YupeModule.yupe', 'Выберите тему сайта'), 'theme');?>
    <?php echo CHtml::dropDownList('theme', $theme, $themes, array('class' => 'span5'));?>
    <br />
    <?php echo CHtml::label(Yii::t('YupeModule.yupe', 'Выберите тему административной части'), 'backendTheme');?>
    <?php echo CHtml::dropDownList('backendTheme', $backendTheme, $backendThemes, array('class' => 'span5', 'empty' => Yii::t('YupeModule.yupe', 'Тема не используется')));?>
    <br /><br />
    <?php echo CHtml::submitButton(Yii::t('YupeModule.yupe', 'Сохранить настройки тем оформления'),array('class' => 'btn btn-primary'));?>

<?php echo CHtml::endForm();?>