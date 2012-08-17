<?php
$this->breadcrumbs=array(   
    Yii::app()->getModule('gallery')->getCategory() => array('admin'), 
	Yii::t('gallery','Галереи')=>array('index'),
	$model->name,
);
$this->pageTitle = Yii::t('gallery','Галереи - просмотр');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('gallery','Управление Галереями'),'url'=>array('/gallery/default/index')),
    array('icon'=> 'file', 'label' =>  Yii::t('gallery','Добавление Галереи'),'url'=>array('/gallery/default/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('gallery','Редактирование Галереи'),'url'=>array('/gallery/default/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('gallery','Просмотреть '). 'Галерею','url'=>array('/gallery/default/view','id'=>$model->id)),
    array('icon'=>'remove', 'label' =>  Yii::t('gallery','Удалить Галерею'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=> Yii::t('gallery','Вы уверены, что хотите удалить?'))),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('gallery','Просмотр');?> Галереи<br />
     <small style='margin-left:-10px;'>&laquo;<?php echo  $model->name; ?>&raquo;</small></h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'status',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ),
)); ?>
