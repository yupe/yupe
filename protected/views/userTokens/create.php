<?php
/* @var $this UserTokensController */
/* @var $model UserTokens */

$this->breadcrumbs=array(
	'User Tokens'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserTokens', 'url'=>array('index')),
	array('label'=>'Manage UserTokens', 'url'=>array('admin')),
);
?>

<h1>Create UserTokens</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>