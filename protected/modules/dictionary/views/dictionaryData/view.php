<?php

$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Данные справочников') => array('admin'),
    Yii::t('dictionary', 'Просмотр'),
);


$this->menu=array(
	array('label' => Yii::t('dictionary', 'Список значений'), 'url'=>array('index')),
	array('label' => Yii::t('dictionary', 'Добавить значение'), 'url'=>array('create')),
	array('label' => Yii::t('dictionary', 'Редактирование значения'), 'url'=>array('update', 'id'=>$model->id)),
	array('label' => Yii::t('dictionary', 'Удалить значение'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Подтверждаете удаление ?')),
	array('label' => Yii::t('dictionary', 'Управление значениями'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('dictionary','Просмотр значения');?> #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
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
