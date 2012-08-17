<?php
$this->breadcrumbs=array(    
	Yii::app()->getModule('gallery')->getCategory() => array('admin'),
	Yii::t('gallery','Галереи')=>array('index'),
	Yii::t('gallery','Добавление'),
);

$this->pageTitle = Yii::t('gallery','Галереи - добавление');

$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('gallery','Управление Галереями'),'url'=>array('/gallery/default/index')),
    array('icon'=> 'file', 'label' => Yii::t('gallery','Добавить Галерею'),'url'=>array('/gallery/default/create')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('gallery','Галереи');?>    <small><?php echo Yii::t('gallery','добавление');?></small>
    </h1>
</div>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>