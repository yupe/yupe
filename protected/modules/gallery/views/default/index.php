<?php
$this->breadcrumbs = array(
    $this->getModule('category')->getCategory() => array(''),
    Yii::t('gallery', 'Галереи изображений') => array('admin'),
);

$this->menu = array(
    array('label' => Yii::t('gallery', 'Добавить галерею'), 'url' => array('create')),
    array('label' => Yii::t('gallery', 'Управление галереями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('gallery', 'Галереи изображений');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>
