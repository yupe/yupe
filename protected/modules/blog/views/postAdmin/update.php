<?php
    $this->breadcrumbs = array(
        Yii::t('blog', 'Блоги')=>array('blogAdmin/admin'),
        Yii::t('blog', 'Записи')=>array('postAdmin/admin'),
        $model->title=>array('view', 'id'=>$model->id),
        Yii::t('blog', 'Редактирование'),
    );

    $this->menu = array(
        array('label'=>Yii::t('blog', 'Список записей'), 'url'=>array('index')),
        array('label'=>Yii::t('blog', 'Добавить запись'), 'url'=>array('create')),
        array('label'=>Yii::t('blog', 'Просмотр записи'), 'url'=>array('view', 'id'=>$model->id)),
        array('label'=>Yii::t('blog', 'Управление записями'), 'url'=>array('admin')),
    );
?>

<h1><?php echo Yii::t('blog', 'Редактирование записи'); ?> "<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>