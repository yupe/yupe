<?php
$this->breadcrumbs = array(
    $this->getModule('news')->getCategory() => array(''),
    Yii::t('news', 'Новости'),
);

$this->menu = array(
    array('label' => Yii::t('news', 'Добавить новость'), 'url' => array('create')),
    array('label' => Yii::t('news', 'Управление новостями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('news', 'Новости');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>
