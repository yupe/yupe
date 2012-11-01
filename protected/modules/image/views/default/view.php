<?php
$this->breadcrumbs=array(
	$this->module->getCategory() => array(''),
	'Изображения'=>array('index'),
	$model->name,
);
$this-> pageTitle ="изображения - ".Yii::t('yupe','просмотр');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление изображениями'),'url'=>array('/image/default/index')),
    array('icon'=> 'file', 'label' =>  Yii::t('yupe','Добавление изображения'),'url'=>array('/image/default/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('yupe','Редактирование '). 'изображения<br /><span class="label" style="font-size: 80%; margin-left:20px;">'.mb_substr($model->name,0,32)."</span>",'url'=>array('/image/default/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('yupe','Просмотреть '). 'изображение','url'=>array('/image/default/view','id'=>$model->id)),
    array('icon'=>'remove', 'label' =>  Yii::t('yupe','Удалить изображение'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=> Yii::t('yupe','Вы уверены, что хотите удалить?'))),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','Просмотр');?> изображения<br />
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
		'file',
		'creation_date',
		'user_id',
		'alt',
		'type',
		'status',
	),
)); ?>
