<?php
$this->breadcrumbs=array(
	'почтовые события'=>array('index'),
	$model->name,
);
$this-> pageTitle ="почтовые события - просмотр";
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление почтовыми событиями'),'url'=>array('/mail/eventAdmin/index')),
    array('icon'=> 'file', 'label' =>  Yii::t('yupe','Добавление почтового события'),'url'=>array('/mail/eventAdmin/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('yupe','Редактирование '). 'почтового события<br /><span class="label" style="font-size: 80%; margin-left:20px;">'.mb_substr($model->name,0,32)."</span>",'url'=>array('mail/eventAdmin/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('yupe','Просмотреть '). 'почтовое событие','url'=>array('/mail/eventAdmin/view','id'=>$model->id)),
    array('icon'=> 'file', 'label' =>  Yii::t('yupe','Добавить почтовый шаблон'),'url'=>array('/mail/templateAdmin/create/','eid' => $model->id)),
    array('icon'=>'remove', 'label' =>  Yii::t('yupe','Удалить почтовое событие'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=> Yii::t('yupe','Вы уверены, что хотите удалить?'))),
);
?>
<div class="page-header">
    <h1>Просмотр почтового события<br />
     <small style='margin-left:-10px;'>&laquo;<?php echo  $model->name; ?>&raquo;</small></h1>
</div>

<?php $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'name',
		'description',
	),
)); ?>
