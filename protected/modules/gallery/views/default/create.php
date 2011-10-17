<?php
$this->breadcrumbs = array(
    $this->getModule('category')->getCategory() => array(''),
    Yii::t('gallery', 'Галереи изображений') => array('admin'),
    Yii::t('gallery', 'Добавление галереи'),
);

$this->menu = array(
    array('label' => Yii::t('gallery', 'Список галерей'), 'url' => array('index')),
    array('label' => Yii::t('gallery', 'Управление галереями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('gallery', 'Добавление галереи');?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>