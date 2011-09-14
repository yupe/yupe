<?php
$this->breadcrumbs = array(
    $this->getModule('image')->getCategory() => array(''),
    Yii::t('image', 'Изображения'),
);

$this->menu = array(
    array('label' => Yii::t('image', 'Добавить изображение'), 'url' => array('create')),
    array('label' => Yii::t('image', 'Управление изображениями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('image', 'Изображения');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>
