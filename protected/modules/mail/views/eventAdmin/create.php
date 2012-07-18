<?php
$this->breadcrumbs=array(
	'почтовые события'=>array('index'),
	Yii::t('yupe','Добавление'),
);

$this->menu=array(
array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление почтовыми событиями'),'url'=>array('/mail/eventAdmin/index')),
    array('icon'=> 'file', 'label' => Yii::t('yupe','Добавить почтовое событие'),'url'=>array('/mail/eventAdmin/create')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','почтовые события');?>    <small><?php echo Yii::t('yupe','добавление');?></small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>