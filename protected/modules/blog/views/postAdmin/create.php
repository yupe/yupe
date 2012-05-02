<?php
    $this->breadcrumbs = array(
        Yii::t('blog', 'Блоги')=>array('blogAdmin/admin'),
        Yii::t('blog', 'Записи')=>array('admin'),
        Yii::t('blog', 'Добавление'),
    );

    $this->menu = array(
        array('label'=>Yii::t('blog', 'Список записей'), 'url'=>array('index')),
        array('label'=>Yii::t('blog', 'Управление записями'), 'url'=>array('admin')),
    );
?>

<h1><?php echo Yii::t('blog', 'Добавление записи'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>