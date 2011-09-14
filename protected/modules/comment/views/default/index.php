<?php
$this->breadcrumbs = array(
    $this->getModule('category')->getCategory() => array(''),
    Yii::t('comment', 'Комментарии'),
);

$this->menu = array(
    array('label' => Yii::t('comment', 'Добавить комментарий'), 'url' => array('create')),
    array('label' => Yii::t('comment', 'Управление комментариями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('comment', 'Комментарии');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>
