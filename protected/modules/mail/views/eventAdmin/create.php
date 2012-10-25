<?php
$this->breadcrumbs=array(
	$this->module->getCategory() => array('index'),
	Yii::t('mail','Почтовые события')=>array('index'),
	Yii::t('mail','Добавление'),
);

$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('mail','Список событий'),'url'=>array('/mail/eventAdmin/index')),
    array('icon'=> 'plus-sign', 'label' => Yii::t('mail','Добавить событие'),'url'=>array('/mail/eventAdmin/create')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('mail','Почтовые события');?>
        <small><?php echo Yii::t('mail','добавление');?></small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>