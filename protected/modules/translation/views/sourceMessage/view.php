<?php
$this->breadcrumbs=array(
	'Source Messages'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SourceMessage', 'url'=>array('index')),
	array('label'=>'Create SourceMessage', 'url'=>array('create')),
	array('label'=>'Update SourceMessage', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SourceMessage', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SourceMessage', 'url'=>array('admin')),
);
?>

<h1>View SourceMessage #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'category',
		'message',
	),
)); ?>
