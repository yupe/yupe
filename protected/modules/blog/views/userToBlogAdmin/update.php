<?php
$this->breadcrumbs=array(
	Yii::t('blog','Блоги')=>array('blogAdmin/admin'),
	Yii::t('blog','Участники')=>array('admin'),
	$model->user->getFullName()=>array('view','id'=>$model->id),
	Yii::t('blog','Редактирование'),
);

$this->menu=array(
	array('label'=>Yii::t('blog','Список участников'), 'url'=>array('index')),
	array('label'=>Yii::t('blog','Добавление участника'), 'url'=>array('create')),
	array('label'=>Yii::t('blog','Просмотр участника'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('blog','Управление участниками'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('blog','Редактирование участника "{name}" блога "{blog}"',array('{name}' => $model->user->getFullName(), '{blog}' => $model->blog->name));?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>