<?php
$this->breadcrumbs=array(
	'Dictionary Datas',
);

$this->menu=array(
	array('label'=>'Create DictionaryData', 'url'=>array('create')),
	array('label'=>'Manage DictionaryData', 'url'=>array('admin')),
);
?>

<h1>Dictionary Datas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
