<?php
$this->breadcrumbs=array(
	Yii::t('blog','Блоги')  => array('blogAdmin/admin'),
	Yii::t('blog','Записи') => array('admin'),
	Yii::t('blog','Управление'),
);

$this->menu=array(
	array('label' => Yii::t('blog','Список записей'), 'url'=>array('index')),
	array('label' => Yii::t('blog','Добавить запись'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('post-grid', {
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
	'id'=>'post-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
		'id',
		'title',
		 array(
		 	'name'  => 'blog_id',
		 	'value' => '$data->blog->name'
	     ),		
		'slug',
		'publish_date',			
		 array(
		 	'name'  => 'status',
		 	'value' => '$data->getStatus()'
	     ),
		array(
			'name'  => 'comment_status',
            'value' => '$data->getCommentStatus()'
		),
		array(
		 	'name'  => 'access_type',
		 	'value' => '$data->getAccessType()'
	     ),
		array(
			'name'  => 'create_user_id',
			'value' => '$data->createUser->getFullName()'
		),
		array(
			'name'  => 'update_user_id',
			'value' => '$data->updateUser->getFullName()'
		),
		array(
			'name'  => 'create_date',
			'value' => '$data->create_date'
		),
		array(
			'name'  => 'update_date',
			'value' => '$data->update_date'
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
