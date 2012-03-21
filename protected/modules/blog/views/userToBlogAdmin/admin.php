<?php
$this->breadcrumbs=array(
	Yii::t('blog','Блоги')=>array('blogAdmin/admin'),
	Yii::t('blog','Участники')=>array('admin'),
	Yii::t('blog','Управление'),
);

$this->menu=array(
	array('label'=>Yii::t('blog','Список участников'), 'url'=>array('index')),
	array('label'=>Yii::t('blog','Добавить участника'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-to-blog-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->module->getName();?></h1>

<?php $this->widget('YModuleInfo'); ?>
<?php echo CHtml::link(Yii::t('blog','Поиск'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-to-blog-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
		'id',
		 array(
		 	'name'  => 'user_id',
		 	'value' => '$data->user->getFullName()'
		 ),
		array(
		 	'name'  => 'blog_id',
		 	'value' => '$data->blog->name'
		 ),
		'create_date',
		'update_date',
		array(
		 	'name'  => 'role',
		 	'value' => '$data->getRole()'
		),
		array(
		 	'name'  => 'status',
		 	'value' => '$data->getStatus()'
		),
		'note',		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
