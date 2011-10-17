<?php
$this->breadcrumbs = array(
    $this->getModule('image')->getCategory() => array(''),
    Yii::t('image', 'Изображения') => array('admin'),
    Yii::t('image', 'Добавление изображения'),
);

$this->menu = array(
    array('label' => Yii::t('image', 'Список изображений'), 'url' => array('index')),
    array('label' => Yii::t('image', 'Управление изображениями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('image', 'Добавление изображения');?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>