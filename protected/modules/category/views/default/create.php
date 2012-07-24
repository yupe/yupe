<?php
$this->breadcrumbs=array(
	'категории'=>array('index'),
	Yii::t('yupe','Добавление'),
);

$this->menu=array(
array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление категориями'),'url'=>array('/category/default/index')),
    array('icon'=> 'file', 'label' => Yii::t('yupe','Добавить категорию'),'url'=>array('/category/default/create')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','категории');?>    <small><?php echo Yii::t('yupe','добавление');?></small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>