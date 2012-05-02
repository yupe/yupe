<?php
    $this->breadcrumbs = array(
        $this->getModule('category')->getCategory()=>array(''),
        Yii::t('category', 'Категории')=>array('index'),
        $model->name=>array('view', 'id'=>$model->id),
        Yii::t('category', 'Изменение категории'),
    );

    $this->menu = array(
        array('label'=>Yii::t('category', 'Добавить категорию'), 'url'=>array('create')),
        array('label'=>Yii::t('category', 'Список категорий'), 'url'=>array('index')),
        array('label'=>Yii::t('category', 'Просмотреть категорию'), 'url'=>array('view', 'id'=>$model->id)),
        array('label'=>Yii::t('category', 'Управление категориями'), 'url'=>array('admin')),
    );
?>

<h1><?php echo Yii::t('category', 'Изменение категории'); ?> "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'categoryes'=>$categoryes)); ?>