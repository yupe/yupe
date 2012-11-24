<?php
$this->breadcrumbs=array(
	$this->module->getCategory() => array(''),
	Yii::t('image','Изображения')=>array('index'),
	Yii::t('image','Добавление'),
);

$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('image','Управление изображениями'),'url'=>array('/image/default/index')),
    array('icon'=> 'plus-sign', 'label' => Yii::t('image','Добавить изображение'),'url'=>array('/image/default/create')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('image','Изображения');?>    <small><?php echo Yii::t('image','добавление');?></small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>