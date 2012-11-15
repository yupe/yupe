<?php
$this->breadcrumbs=array(
    $this->module->getCategory() => array(''),
	Yii::t('category','Категории')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('category','Редактирование'),
);
$this->pageTitle =  Yii::t('category','Категории редактирование');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('category','Управление категориями'),'url'=>array('/category/default/index')),
    array('icon'=> 'plus-sign', 'label' =>  Yii::t('category','Добавить категорию'),'url'=>array('/category/default/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('category','Редактирование категории'),'url'=>array('category/default/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('category','Просмотреть категорию'),'url'=>array('/category/default/view','id'=>$model->id)),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('category','Редактирование категории');?><br />
        <small style="margin-left: -10px;">&laquo; <?php echo  $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form',array('model'=>$model)); ?>