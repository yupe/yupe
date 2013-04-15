<?php
$this->pageTitle = Yii::t('UserModule.user', 'Регистрация нового пользователя');
$this->breadcrumbs = array(Yii::t('UserModule.user', 'Регистрация нового пользователя'));
?>

<h1><?php echo Yii::t('UserModule.user', 'Регистрация нового пользователя'); ?></h1>

<p><?php echo Yii::t('UserModule.user', 'Регистрация отключена!'); ?> <?php echo CHtml::link(Yii::t('UserModule.user', 'Обратитесь к администратору.'), array('/feedback/index')); ?></p>
