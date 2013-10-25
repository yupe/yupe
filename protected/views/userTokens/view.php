<?php
/* @var $this UserTokensController */
/* @var $model UserTokens */

$this->breadcrumbs=array(
	'User Tokens'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UserTokens', 'url'=>array('index')),
	array('label'=>'Create UserTokens', 'url'=>array('create')),
	array('label'=>'Update UserTokens', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserTokens', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserTokens', 'url'=>array('admin')),
);
?>

<h1>View UserTokens #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'token',
		'type',
		'status',
		'created',
		'updated',
		'ip',
	),
)); ?>
