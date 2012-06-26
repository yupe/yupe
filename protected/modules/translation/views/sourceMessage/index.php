<?php
$this->breadcrumbs=array(
	'Source Messages',
);

$this->menu=array(
	array('label'=>'Create SourceMessage', 'url'=>array('create')),
	array('label'=>'Manage SourceMessage', 'url'=>array('admin')),
);
?>

<h1>Source Messages</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
