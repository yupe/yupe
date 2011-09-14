<?php $this->pageTitle = Yii::t('user','Список профилей');?>

<?php
$this->breadcrumbs=array(
	Yii::t('user','Профили'),
);

$this->menu=array(
	array('label'=>Yii::t('user','Управление профилями'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('user','Профили')?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
