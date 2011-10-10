<?php
$this->breadcrumbs=array(
	'Dictionary Datas'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List DictionaryData', 'url'=>array('index')),
	array('label'=>'Create DictionaryData', 'url'=>array('create')),
	array('label'=>'Update DictionaryData', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete DictionaryData', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DictionaryData', 'url'=>array('admin')),
);
?>

<h1>View DictionaryData #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'group_id',
		'code',
		'name',
		'description',
		'creation_date',
		'update_date',
		'create_user_id',
		'update_user_id',
		'status',
	),
)); ?>
