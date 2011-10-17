<?php
$this->breadcrumbs = array(
    $this->getModule('contentblock')->getCategory() => array(''),
    Yii::t('contentblock', 'Блоки контента'),
);

$this->menu = array(
    array('label' => Yii::t('contentblock', 'Добавить новый блок'), 'url' => array('create')),
    array('label' => Yii::t('contentblock', 'Управление блоками контента'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('contentblock', 'Блоки контента');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>
