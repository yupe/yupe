<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Группы справочников') => array('admin'),
    Yii::t('dictionary', 'Управление'),
);

$this->menu=array(
	array('label' => Yii::t('dictionary', 'Список групп'), 'url'=>array('index')),
	array('label' => Yii::t('dictionary', 'Добавить группу'), 'url'=>array('create')),
	array('label' => Yii::t('dictionary', 'Добавить значение'), 'url'=>array('dictionaryData/create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('dictionary-group-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->module->getName();?></h1>

<?php $this->widget('YModuleInfo'); ?>

<?php echo CHtml::link(Yii::t('dictionary','Поиск'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'dictionary-group-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
		'id',
		'code',
		'name',		
		array(
			'name'  => Yii::t('dictionary','Записей'),
			'value' => '$data->dataCount'
		),
		'creation_date',
		'update_date',		
		array(
			'name'  => 'create_user_id',
			'value' => '$data->createUser->getFullName()'
		),
		array(
			'name'  => 'update_user_id',
			'value' => '$data->updateUser->getFullName()'
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
