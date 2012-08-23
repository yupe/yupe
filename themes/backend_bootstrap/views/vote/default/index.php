<?php
$this->breadcrumbs = array(
    $this->getModule('vote')->getCategory() => array(''),
    Yii::t('vote', 'Голосование') => array('admin'),
    Yii::t('vote', 'Список'),
);


$this->menu = array(
    array('label' => Yii::t('vote', 'Добавить голос'), 'url' => array('create')),
    array('label' => Yii::t('vote', 'Управление голосами'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('vote', 'Список голосов');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>
