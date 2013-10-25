<?php
/* @var $this UserTokensController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'User Tokens',
);

$this->menu=array(
	array('label'=>'Create UserTokens', 'url'=>array('create')),
	array('label'=>'Manage UserTokens', 'url'=>array('admin')),
);
?>

<h1>User Tokens</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
