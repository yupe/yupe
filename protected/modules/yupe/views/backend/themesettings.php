<?php
$this->breadcrumbs = array(
    Yii::t('yupe', 'Настройки') => array('settings'),
    Yii::t('yupe', 'Темы оформления'),
);?>

<h1><?php echo Yii::t('yupe', 'Выбор темы оформления');?></h1>

<p><?php echo Yii::t('yupe', 'Текущая тема')?>: <b><?php echo $theme;?></b></p>

<div class="form">

    <?php echo CHtml::beginForm(array('/yupe/backend/themesettings', 'post')); ?>
    <div class="row">
        <?php echo CHtml::label(Yii::t('yupe', 'Выберите тему'), 'theme');?>
        <?php echo CHtml::dropDownList('theme', $theme, $themes);?>
    </div>
    <div class="row submit">
        <?php echo CHtml::submitButton(Yii::t('yupe', 'Сохранить настройки'));?>
    </div>
    <?php echo CHtml::endForm();?>

</div>    