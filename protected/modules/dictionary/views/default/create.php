<?php
$this->breadcrumbs=array(
	'Dictionary Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DictionaryGroup', 'url'=>array('index')),
	array('label'=>'Manage DictionaryGroup', 'url'=>array('admin')),
);
?>

<h1>Create DictionaryGroup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>