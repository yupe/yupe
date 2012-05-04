<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Данные справочников') => array('admin'),
    Yii::t('dictionary', 'Управление'),
);

$this->menu=array(
	array('label' => Yii::t('dictionary','Список данных'), 'url'=>array('index')),
	array('label' => Yii::t('dictionary','Добавить данные'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('dictionary-data-grid', {
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

<?php $this->widget('YCustomGridView', array(
	'id'=>'dictionary-data-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
		'id',		
		'code',
		'name',
		'value',
		array(
			'name'  => 'group_id',
			'value' => '$data->group->name'
		),
		'description',
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
            'name' => 'status',
            'type' => 'raw',
            'value' => '$this->grid->returnStatusHtml($data)'
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
