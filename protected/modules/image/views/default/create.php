<?php
$this->breadcrumbs=array(
	$this->module->getCategory() => array(''),
	'Изображения'=>array('index'),
	Yii::t('yupe','Добавление изображения'),
);

$this->menu=array(
array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление изображениями'),'url'=>array('/image/default/index')),
    array('icon'=> 'file', 'label' => Yii::t('yupe','Добавить изображение'),'url'=>array('/image/default/create')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','изображения');?>    <small><?php echo Yii::t('yupe','добавление');?></small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>