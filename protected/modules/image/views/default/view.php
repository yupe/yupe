<?php
$this->breadcrumbs=array(
	$this->module->getCategory() => array(''),
	Yii::t('image','Изображения')=>array('index'),
	$model->name,
);
$this-> pageTitle = Yii::t('image','Просмотр изображения');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('image','Управление изображениями'),'url'=>array('/image/default/index')),
    array('icon'=> 'plus-sign', 'label' =>  Yii::t('image','Добавление изображения'),'url'=>array('/image/default/create')),
    array('icon'=>'pencil','encodeLabel'=> false, 'label' => Yii::t('image','Редактирование изображения'),'url'=>array('/image/default/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('image','Просмотреть '). 'изображение','url'=>array('/image/default/view','id'=>$model->id)),
    array('icon'=>'remove', 'label' =>  Yii::t('image','Удалить изображение'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=> Yii::t('yupe','Вы уверены, что хотите удалить?'))),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('image','Просмотр изображения');?> <br />
     <small style='margin-left:-10px;'>&laquo;<?php echo  $model->name; ?>&raquo;</small></h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'category_id',
		'parent_id',
		'name',
		'description',
		 array(
		 	'name' => 'file',
		 	'type' => 'raw',
		 	'value' => CHtml::image($model->file,$model->alt)
	     ),
		'creation_date',
		array(
			'name'  => 'user_id',
			'value' => $model->user->getFullName(),
	    ),
		'alt',
		array(
			'name'  => 'type',
			'value' => $model->getType(),
	    ),
		array(
			'name'  => 'status',
			'value' => $model->getStatus(),
	    )
	),
)); ?>
