<?php
$this->breadcrumbs=array(
	'Source Messages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SourceMessage', 'url'=>array('index')),
	array('label'=>'Manage SourceMessage', 'url'=>array('admin')),
);
?>

<h1>Create SourceMessage</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>