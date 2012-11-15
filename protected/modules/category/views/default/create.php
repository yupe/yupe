<?php
$this->breadcrumbs=array(
	$this->module->getCategory() => array(''),
	Yii::t('category','Категории')=>array('index'),
	Yii::t('category','Добавление'),
);

$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('category','Управление категориями'),'url'=>array('/category/default/index')),
    array('icon'=> 'plus-sign', 'label' => Yii::t('category','Добавить категорию'),'url'=>array('/category/default/create')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('category','Категории');?>    <small><?php echo Yii::t('category','добавление');?></small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>