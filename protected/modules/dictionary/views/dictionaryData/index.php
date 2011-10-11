<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Данные справочников') => array('admin'),
    Yii::t('dictionary', 'Список значений'),
);

$this->menu=array(
	array('label' => Yii::t('dictionary', 'Добавить значение'), 'url'=>array('create')),
	array('label' => Yii::t('dictionary', 'Управление значениями'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('dictionary', 'Список значений');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
