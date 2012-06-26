<?php
$this->breadcrumbs=array(
	'Messages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Message', 'url'=>array('index')),
	array('label'=>'Manage Message', 'url'=>array('admin')),
);
?>

<h1>Create Message</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'messages' => $messages)); ?>