<?php
$this->breadcrumbs=array(   
    Yii::app()->getModule('gallery')->getCategory() => array('admin'), 
	Yii::t('gallery','Галереи')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('gallery','Редактирование'),
);
$this->pageTitle = Yii::t('gallery','Галереи - редактирование');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('gallery','Управление Галереями'),'url'=>array('/gallery/default/index')),
    array('icon'=> 'file', 'label' =>  Yii::t('gallery','Добавить Галерею'),'url'=>array('/gallery/default/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('gallery','Редактирование Галереи'),'url'=>array('/gallery/default/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('gallery','Просмотреть '). 'Галерею','url'=>array('/gallery/default/view','id'=>$model->id)),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('gallery','Редактирование');?> <?php echo Yii::t('gallery','Галерее');?><br />
        <small style="margin-left: -10px;">&laquo; <?php echo  $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form',array('model'=>$model)); ?>