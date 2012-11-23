<?php

$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Данные справочников') => array('admin'),
    Yii::t('dictionary', 'Просмотр'),
);


$this->menu=array(
	array('icon' => 'list-alt','label' => Yii::t('dictionary', 'Список значений'), 'url'=>array('/dictionary/dictionaryData/admin')),
	array('icon' => 'plus-sign','label' => Yii::t('dictionary', 'Добавить значение'), 'url'=>array('/dictionary/dictionaryData/create')),
	array('icon' => 'eye-open','label' => Yii::t('dictionary', 'Редактирование значения'), 'url'=>array('/dictionary/dictionaryData/update', 'id'=>$model->id)),
	array('icon' => 'trash','label' => Yii::t('dictionary', 'Удалить значение'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Подтверждаете удаление ?')),	
);
?>

<h1><?php echo Yii::t('dictionary','Просмотр значения');?> "<?php echo $model->name; ?>"</h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name'  => 'group_id',
			'value' => $model->group->name
		),
		'code',
		'name',
		'value',
		'description',
		'creation_date',
		'update_date',
		array(
			'name'  => 'create_user_id',
			'value' => $model->createUser->getFullName()
		),
		array(
			'name'  => 'update_user_id',
			'value' => $model->updateUser->getFullName()
		),
		array(
			'name'  => 'status',
			'value' => $model->getStatus()
		),
	),
)); ?>
