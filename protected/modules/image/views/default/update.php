<?php
$this->breadcrumbs=array(
    $this->module->getCategory() => array(''),
	Yii::t('image','Изображения')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('image','Редактирование'),
);
$this->pageTitle = Yii::t('image','Редактирование изображения');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('image','Список изображений'),'url'=>array('/image/default/index')),
    array('icon'=> 'plus-sign', 'label' =>  Yii::t('image','Добавить изображение'),'url'=>array('/image/default/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('image','Редактирование изображение'),'url'=>array('image/default/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('image','Просмотреть изображение'),'url'=>array('/image/default/view','id'=>$model->id)),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('image','Редактирование изображения');?><br />
        <small style="margin-left: -10px;">&laquo;<?php echo  $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form',array('model'=>$model)); ?>