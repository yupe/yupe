<?php $this->pageTitle = Yii::t('user','Список регистраций');?>

<?php
$this->breadcrumbs=array(
	Yii::t('user','Пользователи')=>array('/user/default/admin/'),
	Yii::t('user','Регистрации')
);

$this->menu=array(	
	array('label'=>Yii::t('user','Управление регистрациями'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('user','Управление регистрациями');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
