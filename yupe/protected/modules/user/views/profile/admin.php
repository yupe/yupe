<?php $this->pageTitle = Yii::t('user','Управление профилями');?>

<?php
$this->breadcrumbs=array(
	Yii::t('user','Профили')=>array('admin'),
	Yii::t('user','Управление'),
);

$this->menu=array(
	array('label'=>Yii::t('user','Список профилей'), 'url'=>array('index')),	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('profile-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('user','Управление профилями')?></h1>


<?php echo CHtml::link(Yii::t('user','Поиск'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'profile-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(		
		 array(
			'name'  => 'userId',
			'value' => '$data->user->nickName'
		 ),
		'twitter',
		'livejournal',
		'vkontakte',
		'odnoklassniki',
		/*
		'facebook',
		'yandex',
		'google',
		'blog',
		'site',
		'about',
		'location',
		'phone',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
