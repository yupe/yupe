<?php
$this->breadcrumbs=array(
	Yii::t('menu','Меню')=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('menu','Редактирование'),
);

$this->menu=array(
	array('label'=>Yii::t('menu','Спсиок меню'), 'url'=>array('index')),
	array('label'=>Yii::t('menu','Добавить меню'), 'url'=>array('create')),
	array('label'=>Yii::t('menu','Просмотр меню'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('menu','Управление меню'), 'url'=>array('admin')),
	array('label' => Yii::t('menu','Добавить пункт меню'), 'url'=>array('addMenuItem')),
);
?>

<h1><?php echo Yii::t('menu','Редактирование меню');?> "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>