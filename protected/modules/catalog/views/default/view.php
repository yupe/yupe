<?php
$this->breadcrumbs=array(
	$this->module->getCategory() => array(''),
	'Товары'=>array('index'),
	$model->name,
);
$this-> pageTitle ="товары - ".Yii::t('yupe','просмотр');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление товарами'),'url'=>array('/catalog/default/index')),
    array('icon'=> 'file', 'label' =>  Yii::t('yupe','Добавление товара'),'url'=>array('/catalog/default/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('yupe','Редактирование '). 'товара<br /><span class="label" style="font-size: 80%; margin-left:20px;">'.mb_substr($model->name,0,32)."</span>",'url'=>array('/catalog/default/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('yupe','Просмотреть '). 'товар','url'=>array('/catalog/default/view','id'=>$model->id)),
    array('icon'=>'remove', 'label' =>  Yii::t('yupe','Удалить товар'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=> Yii::t('yupe','Вы уверены, что хотите удалить?'))),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','Просмотр товара');?><br />
     <small style='margin-left:-10px;'>&laquo;<?php echo  $model->name; ?>&raquo;</small></h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name'  => 'category_id',
			'value' => $model->category->name
		),
		'name',
		'alias',
		array(
			'name'  => 'price',
			'value' => number_format($model->price,2,'.','')
		),
		'article',
		array(
                    'name'  => 'image',
                    'type'  => 'raw',
                    'value' => $model->image ? CHtml::image(Yii::app()->baseUrl.'/'.Yii::app()->getModule('yupe')->uploadPath . DIRECTORY_SEPARATOR . $this->module->uploadPath.DIRECTORY_SEPARATOR.$model->image, $model->name,array('width' => 300,'height' => 300)) : '---'
                ),		
		'create_time',
		'update_time',
		array(
			'name'  => 'user_id',
			'value' => $model->user->getFullName()
		),
		array(
			'name'  => 'change_user_id',
			'value' => $model->changeUser->getFullName()
		),		
		array(
			'name' => 'description',
			'type' => 'raw'
		),
		array(
			'name' => 'short_description',
			'type' => 'raw'
		),		
		array(
			'name'  => 'status',
			'value' => $model->getStatus()
		),		
	),
)); ?>
