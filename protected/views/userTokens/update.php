<?php
/* @var $this UserTokensController */
/* @var $model UserTokens */

$this->breadcrumbs=array(
	'User Tokens'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserTokens', 'url'=>array('index')),
	array('label'=>'Create UserTokens', 'url'=>array('create')),
	array('label'=>'View UserTokens', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserTokens', 'url'=>array('admin')),
);
?>

<h1>Update UserTokens <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>