<?php
$this->pageTitle = Yii::t('UserModule.user', 'Восстановление пароля');
$this->breadcrumbs = array(Yii::t('UserModule.user', 'Восстановление пароля'));
?>

<h1><?php echo Yii::t('UserModule.user', 'Восстановление пароля'); ?></h1>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>


<p><?php echo Yii::t('UserModule.user', 'Восстановление пароля отключено!'); ?> <?php echo CHtml::link(Yii::t('UserModule.user', 'Обратитесь к администратору.'), array('/feedback/index')); ?></p>
