<?php
$this->breadcrumbs = array(
    Yii::t('YupeModule.yupe', 'System') => array('settings'),   
    Yii::t('YupeModule.yupe', 'Themes'),
);
?>

<h1><?php echo Yii::t('YupeModule.yupe', 'Theme choise');?></h1>

<div class="alert alert-block alert-info">
    <?php echo Yii::t('YupeModule.yupe', 'Current theme'); ?>: <b><?php echo $theme; ?></b>,
    <?php echo Yii::t('YupeModule.yupe', 'Current backend theme'); ?>: <b><?php echo $backendTheme; ?></b>
    <p><?php echo CHtml::link(Yii::t('YupeModule.yupe', 'More about themes'),'http://yiiframework.com/doc/guide/topics.theming',array('target' => '_blank'));?></p>
</div>


<?php echo CHtml::beginForm(array('/yupe/backend/themesettings', 'post'), 'post', array('class' => 'well')); ?>
    <?php echo CHtml::label(Yii::t('YupeModule.yupe', 'Choose site theme'), 'theme');?>
    <?php echo CHtml::dropDownList('theme', $theme, $themes, array('class' => 'span5'));?>
    <br />
    <?php echo CHtml::label(Yii::t('YupeModule.yupe', 'Choose backend theme'), 'backendTheme');?>
    <?php echo CHtml::dropDownList('backendTheme', $backendTheme, $backendThemes, array('class' => 'span5', 'empty' => Yii::t('YupeModule.yupe', 'Theme is not using')));?>
    <br /><br />
    <?php echo CHtml::submitButton(Yii::t('YupeModule.yupe', 'Save themes settings'),array('class' => 'btn btn-primary'));?>

<?php echo CHtml::endForm();?>