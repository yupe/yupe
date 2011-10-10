<?php
$this->breadcrumbs=array(
	'Dictionary Groups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List DictionaryGroup', 'url'=>array('index')),
	array('label'=>'Create DictionaryGroup', 'url'=>array('create')),
	array('label'=>'Update DictionaryGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete DictionaryGroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DictionaryGroup', 'url'=>array('admin')),
);
?>

<h1>View DictionaryGroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'name',
		'description',
		'creation_date',
		'update_date',
		'create_user_id',
		'update_user_id',
	),
)); ?>
