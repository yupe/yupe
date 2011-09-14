<?php
$this->breadcrumbs=array(
	Yii::t('user','Пользователи')=>array('/user/default/admin/'),
	Yii::t('user','Авторизационные данные') => array('admin'),
	Yii::t('user','Управление'),
);

$this->menu=array(
	array('label'=>Yii::t('user','Список'), 'url'=>array('index')),	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('login-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('user','Авторизационные данные');?></h1>


<?php echo CHtml::link(Yii::t('user','Поиск'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'login-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'id',
		 array(
			'name'  => 'userId',
			'value' => '$data->user->getFullName()." ({$data->user->nickName})"' 
		 ),
		'identityId',
		'type',
		'creationDate',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
