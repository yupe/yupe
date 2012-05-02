<?php
    $this->breadcrumbs = array(
        Yii::t('blog', 'Блоги')=>array('admin'),
        Yii::t('blog', 'Добавление'),
    );

    $this->menu = array(
        array('label'=>Yii::t('blog', 'Список блогов'), 'url'=>array('index')),
        array('label'=>Yii::t('blog', 'Управление блогами'), 'url'=>array('admin')),
    );
?>

<h1><?php echo Yii::t('blog','Добавление блога'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>