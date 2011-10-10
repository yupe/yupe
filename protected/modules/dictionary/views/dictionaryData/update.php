<?php
$this->breadcrumbs=array(
	'Dictionary Datas'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DictionaryData', 'url'=>array('index')),
	array('label'=>'Create DictionaryData', 'url'=>array('create')),
	array('label'=>'View DictionaryData', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DictionaryData', 'url'=>array('admin')),
);
?>

<h1>Update DictionaryData <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>