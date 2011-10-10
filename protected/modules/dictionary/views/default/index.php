<?php
$this->breadcrumbs=array(
	'Dictionary Groups',
);

$this->menu=array(
	array('label'=>'Create DictionaryGroup', 'url'=>array('create')),
	array('label'=>'Manage DictionaryGroup', 'url'=>array('admin')),
);
?>

<h1>Dictionary Groups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
