<?php
$this->breadcrumbs=array(
	'категории'=>array('index'),
	$model->name,
);
$this-> pageTitle ="категории - просмотр";
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => 'Управление категориями','url'=>array('/category/default/index')),
    array('icon'=> 'file', 'label' => 'Добавить категорию','url'=>array('/category/default/create')),
    array('icon'=> 'pencil', 'label' => 'Редактировать категорию','url'=>array('/category/default/update','id'=>$model->id)),
    array('icon'=> 'eye-open white', 'encodeLabel'=>false, 'label' => 'Просмотр категорию<br /><span class="label" style="font-size: 80%; margin-left:20px;">'.mb_substr($model->name,0,32)."</span>",'url'=>array('category/default/view','id'=>$model->id)),
    array('icon'=>'remove', 'label' => 'Удалить категорию','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить?')),
);
?>
<div class="page-header">
    <h1>Просмотр категорию<br />
     <small style='margin-left:-10px;'>&laquo;<?php echo  $model->name; ?>&raquo;</small></h1>
</div>

<?php $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parent_id',
		'name',
		'description',
		'alias',
		'status',
	),
)); ?>
