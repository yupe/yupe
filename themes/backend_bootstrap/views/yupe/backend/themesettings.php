<?php
$this->breadcrumbs = array(
    Yii::t('yupe', 'Настройки') => array('settings'),
    Yii::t('yupe', 'Темы оформления'),
);?>

<h1><?php echo Yii::t('yupe', 'Выбор темы оформления');?></h1>

<p>
<?php echo Yii::t('yupe', 'Текущая тема')?>: <b><?php echo $theme;?></b>
<?php echo Yii::t('yupe', 'Текущая тема административной части')?>: <b><?php echo $backendTheme;?></b>
</p>

    <?php echo CHtml::beginForm(array('/yupe/backend/themesettings', 'post'),'post',array(
                                'class'=>'well',
                                )); ?>
        <?php echo CHtml::label(Yii::t('yupe', 'Выберите тему сайта'), 'theme');?>
        <?php echo CHtml::dropDownList('theme', $theme, $themes);?>
        <br />
        <?php echo CHtml::label(Yii::t('yupe', 'Выберите тему административной части'), 'backendTheme');?>
        <?php echo CHtml::dropDownList('backendTheme', $backendTheme, $backendThemes);?>
        <br />
        <?php echo CHtml::submitButton(Yii::t('yupe', 'Сохранить настройки'),array('class'=> 'btn btn-primary'));?>

    <?php echo CHtml::endForm();?>

