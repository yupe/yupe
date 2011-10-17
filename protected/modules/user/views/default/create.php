<?php $this->pageTitle = Yii::t('user', 'Добавление пользователя'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('index'),
    Yii::t('user', 'Добавление пользователя'),
);

$this->menu = array(
    array('label' => Yii::t('user', 'Список пользователей'), 'url' => array('index')),
    array('label' => Yii::t('user', 'Управление пользователями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('user', 'Добавление пользователя')?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>