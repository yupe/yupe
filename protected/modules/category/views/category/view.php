<?php
$this->breadcrumbs=array(
	'категории'=>array('index'),
	$model->name,
);
$this-> pageTitle ="категории - ".Yii::t('yupe','просмотр');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление категориями'),'url'=>array('/category/category/index')),
    array('icon'=> 'file', 'label' =>  Yii::t('yupe','Добавление категории'),'url'=>array('/category/category/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('yupe','Редактирование '). 'категории<br /><span class="label" style="font-size: 80%; margin-left:20px;">'.mb_substr($model->name,0,32)."</span>",'url'=>array('/category/category/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('yupe','Просмотреть '). 'категорию','url'=>array('/category/category/view','id'=>$model->id)),
    array('icon'=>'remove', 'label' =>  Yii::t('yupe','Удалить категорию'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=> Yii::t('yupe','Вы уверены, что хотите удалить?'))),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','просмотр');?> категории<br />
     <small style='margin-left:-10px;'>&laquo;<?php echo  $model->name; ?>&raquo;</small></h1>
</div>

<?php $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parent_id',
		'name',
		'description',
		'alias',
		'status',
	),
)); ?>
