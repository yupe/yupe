<?php
$this->breadcrumbs=array(
	'Dictionary Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DictionaryGroup', 'url'=>array('index')),
	array('label'=>'Create DictionaryGroup', 'url'=>array('create')),
	array('label'=>'View DictionaryGroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DictionaryGroup', 'url'=>array('admin')),
);
?>

<h1>Update DictionaryGroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>