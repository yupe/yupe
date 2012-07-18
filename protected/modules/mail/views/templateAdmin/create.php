<?php
$this->breadcrumbs=array(
	'почтовые шаблоны'=>array('index'),
	Yii::t('yupe','Добавление'),
);

$this->menu=array(
array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление почтовыми шаблонами'),'url'=>array('/mail/templateAdmin/index')),
    array('icon'=> 'file', 'label' => Yii::t('yupe','Добавить почтовый шаблон'),'url'=>array('/mail/templateAdmin/create')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','почтовые шаблоны');?>    <small><?php echo Yii::t('yupe','добавление');?></small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>