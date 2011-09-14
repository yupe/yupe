<?php echo $this->pageTitle = Yii::t('user','Редактирование профиля');?>

<?php
$this->breadcrumbs=array(
	Yii::t('user','Профили')=>array('admin'),
	$model->userId=>array('view','id'=>$model->userId),
	Yii::t('user','Изменение'),
);

$this->menu=array(
	array('label'=>Yii::t('user','Список профилей'), 'url'=>array('index')),	
	array('label'=>Yii::t('user','Просмотр профиля'), 'url'=>array('view', 'id'=>$model->userId)),
	array('label'=>Yii::t('user','Управление профилями'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('user','Изменение профиля')?> <?php echo $model->user->nickName; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>