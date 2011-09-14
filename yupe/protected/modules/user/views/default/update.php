<?php $this->pageTitle = Yii::t('user','Редактирование пользователя');?>

<?php
$this->breadcrumbs=array(
	Yii::t('user','Пользователи')=>array('index'),
	$model->nickName => array('view','id'=>$model->id),
	Yii::t('user','Редактирование'),
);

$this->menu=array(
	array('label'=>Yii::t('user','Список пользователей'), 'url'=>array('index')),
	array('label'=>Yii::t('user','Добавление пользователя'), 'url'=>array('create')),
	array('label'=>Yii::t('user','Просмотр пользователя'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('user','Управление пользователями'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('user','Редактирование пользователя')?> "<?php echo $model->nickName; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>