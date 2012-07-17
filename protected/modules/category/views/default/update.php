<?php
$this->breadcrumbs=array(
	'категории'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Редактирование',
);
$this-> pageTitle ="категории - редактирование";
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => 'Управление категориями','url'=>array('/category/default/index')),
    array('icon'=> 'file', 'label' => 'Добавить категорию','url'=>array('/category/default/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => 'Редактирование категорию<br /><span class="label" style="font-size: 80%; margin-left:20px;">'.mb_substr($model->name,0,32)."</span>",'url'=>array('category/default/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => 'Просмотреть категорию','url'=>array('/category/default/view','id'=>$model->id)),
);
?>
<div class="page-header">
    <h1>Редактирование категории<br />
        <small style="margin-left: -10px;">&laquo; <?php echo  $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form',array('model'=>$model)); ?>