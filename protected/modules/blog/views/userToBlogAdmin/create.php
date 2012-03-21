<?php
$this->breadcrumbs=array(
	Yii::t('blog','Блоги')=>array('blogAdmin/admin'),
	Yii::t('blog','Участники')=>array('admin'),
	Yii::t('blog','Добавление'),
);

$this->menu=array(
	array('label'=>Yii::t('blog','Список участников'), 'url'=>array('index')),
	array('label'=>Yii::t('blog','Управление участниками'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('blog','Добавление участника')?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>