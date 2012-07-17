<?php
$this->breadcrumbs=array(
	'категории'=>array('index'),
	'Создание',
);

$this->menu=array(
    array('icon'=> 'list-alt', 'label' => 'Управление категориями','url'=>array('/category/default/index')),
    array('icon'=> 'file', 'label' => 'Добавление категорию','url'=>array('/category/default/create')),
);
?>
<div class="page-header">
    <h1>категории    <small>добавление</small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>