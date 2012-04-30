<?php
    $this->breadcrumbs = array(
        Yii::t('menu', 'Меню')=>array('admin'),
        Yii::t('menu', 'Добавление'),
    );
    
    $this->menu = array(
        array('label'=>Yii::t('menu', 'Список меню'), 'url'=>array('index')),
        array('label'=>Yii::t('menu', 'Упраление меню'), 'url'=>array('admin')),
    );
?>

<h1><?=Yii::t('menu', 'Добавление нового меню')?></h1>

<?=$this->renderPartial('_form', array('model'=>$model))?>