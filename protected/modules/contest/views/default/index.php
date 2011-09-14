<?php
$this->breadcrumbs = array(
    $this->getModule('contest')->getCategory() => array(''),
    Yii::t('contest', 'Конкурсы изображений') => array('admin'),
    Yii::t('contest', 'Список'),
);

$this->menu = array(
    array('label' => Yii::t('contest', 'Добавить конкурс'), 'url' => array('create')),
    array('label' => Yii::t('contest', 'Управление конкурсами'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('contest', 'Конкурсы изображений');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>
