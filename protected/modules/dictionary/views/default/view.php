<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Группы справочников') => array('admin'),
    Yii::t('dictionary', 'Просмотр'),
);

$this->menu=array(
	array('label' => Yii::t('dictionary', 'Список групп'), 'url'=>array('index')),
	array('label' => Yii::t('dictionary', 'Добавить группу'), 'url'=>array('create')),
	array('label' => Yii::t('dictionary', 'Редактировать группу'), 'url'=>array('update', 'id'=>$model->id)),
	array('label' => Yii::t('dictionary', 'Удалить группу'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Подтверждаете удаление ?')),
	array('label' => Yii::t('dictionary', 'Управление группами'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('dictionary', 'Просмотр группы справочников');?> #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'name',
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
	),
)); ?>
