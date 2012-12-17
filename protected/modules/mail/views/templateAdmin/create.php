<?php
$this->breadcrumbs=array(
	$this->module->getCategory() => array('index'),
        Yii::t('mail','Почтовые события')=>array('/mail/eventAdmin/'),
	Yii::t('mail','Почтовые шаблоны')=>array('index'),
	Yii::t('mail','Добавление'),
);

$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('mail','Список шаблонов'),'url'=>array('/mail/templateAdmin/index')),
    array('icon'=> 'plus-sign', 'label' => Yii::t('mail','Добавить шаблон'),'url'=>array('/mail/templateAdmin/create')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('mail','Почтовые шаблоны');?>  <small><?php echo Yii::t('mail','добавление');?></small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>