<?php
    $this->breadcrumbs = array(
        $this->getModule('category')->getCategory()=>array(''),
        Yii::t('category', 'Категории')=>array('index'),
        Yii::t('category', 'Добавление категории'),
    );
    
    $this->menu = array(
        array('label'=>Yii::t('category', 'Список категорий'), 'url'=>array('index')),
        array('label'=>Yii::t('category', 'Управление категориями'), 'url'=>array('admin')),
    );
?>

<h1><?php echo Yii::t('category', 'Добавление категории'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'categoryes'=>$categoryes)); ?>