<?php
$this->breadcrumbs=array(
    $this->module->getCategory() => array('index'),
	Yii::t('mail','Почтовые шаблоны')=>array('index'),
        Yii::t('mail','Почтовые события')=>array('/mail/eventAdmin/'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('mail','Редактирование'),
);
$this->pageTitle = Yii::t('mail','Редактирование почтового шаблона');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('mail','Список шаблонов'),'url'=>array('/mail/templateAdmin/index')),
    array('icon'=> 'plus-sign', 'label' =>  Yii::t('mail','Добавить шаблон'),'url'=>array('/mail/templateAdmin/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('mail','Редактирование шаблона '),'url'=>array('mail/templateAdmin/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('mail','Просмотреть шаблон'),'url'=>array('/mail/templateAdmin/view','id'=>$model->id)),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('mail','Редактирование шаблона');?><br />
        <small style="margin-left: -10px;">&laquo; <?php echo  $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form',array('model'=>$model)); ?>