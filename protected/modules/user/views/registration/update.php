<?php $this->pageTitle = Yii::t('user','Редактирование регистрации');?>

<?php
$this->breadcrumbs=array(
	Yii::t('user','Пользователи')=>array('/user/default/admin/'),
	Yii::t('user','Регистрации') => array('admin'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('user','Изменение'),
);

$this->menu=array(
	array('label'=>Yii::t('user','Список регистраций'), 'url'=>array('index')),	
	array('label'=>Yii::t('user','Просмотр регистрации'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('user','Управление регистрациями'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('user','изменение регистрации ');?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>