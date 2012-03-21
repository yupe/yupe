<?php
$this->breadcrumbs=array(
	Yii::t('blog','Блоги')=>array('blogAdmin/admin'),
	Yii::t('blog','Участники')=>array('admin'),
	$model->user->getFullName()=>array('view','id'=>$model->id),
	Yii::t('blog','Просмотр'),
);

$this->menu=array(
	array('label'=>Yii::t('blog','Список участников'), 'url'=>array('index')),
	array('label'=>Yii::t('blog','Добавление участника'), 'url'=>array('create')),
	array('label'=>Yii::t('blog','Редактировать участника'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('blog','Удалить участника'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('blog','Подтверждаете удаление ?'))),
	array('label'=>Yii::t('blog','Управление участниками'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('blog','Просмотр участника "{name}" блога "{blog}"',array('{name}' => $model->user->getFullName(), '{blog}' => $model->blog->name));?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		 array(
		 	'name'  => 'user_id',
		 	'value' => $model->user->getFullName()
		 ),
		array(
		 	'name'  => 'blog_id',
		 	'value' => $model->blog->name
		 ),
		'create_date',
		'update_date',
		array(
		 	'name'  => 'role',
		 	'value' => $model->getRole()
		),
		array(
		 	'name'  => 'status',
		 	'value' => $model->getStatus()
		),
		'note',		
		array(
			'class'=>'CButtonColumn',
		),
	))) ?>
