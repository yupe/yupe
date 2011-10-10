<?php
$this->breadcrumbs=array(
	'Dictionary Datas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DictionaryData', 'url'=>array('index')),
	array('label'=>'Manage DictionaryData', 'url'=>array('admin')),
);
?>

<h1>Create DictionaryData</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>