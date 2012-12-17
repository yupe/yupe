<?php
$this->breadcrumbs=array(
    $this->module->getCategory() => array('index'),
	Yii::t('mail','Почтовые события')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('mail','Редактирование'),
);
$this->pageTitle = Yii::t('mail','Редактирование почтового события');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('mail','Список событий'),'url'=>array('/mail/eventAdmin/index')),
    array('icon'=> 'plus-sign', 'label' =>  Yii::t('mail','Добавить событие'),'url'=>array('/mail/eventAdmin/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('mail','Редактирование события'),'url'=>array('mail/eventAdmin/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('mail','Просмотреть событие'),'url'=>array('/mail/eventAdmin/view','id'=>$model->id)),
    array('icon'=> 'plus-sign', 'label' =>  Yii::t('mail','Добавить шаблон'),'url'=>array('/mail/templateAdmin/create/','eid' => $model->id)),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('mail','Редактирование почтового сообщения');?><br />
        <small style="margin-left: -10px;">&laquo; <?php echo  $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form',array('model'=>$model)); ?>