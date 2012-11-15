<?php
$this->breadcrumbs=array(
    $this->module->getCategory() => array('index'),
    Yii::t('mail','Почтовые события')=>array('index'),
    $model->name,
);
$this-> pageTitle = Yii::t('mail','Просмотр почтового события');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('mail','Список событий'),'url'=>array('/mail/eventAdmin/index')),
    array('icon'=> 'plus-sign', 'label' =>  Yii::t('mail','Добавление события'),'url'=>array('/mail/eventAdmin/create')),
    array('icon'=>'pencil','encodeLabel'=> false, 'label' => Yii::t('mail','Редактирование события'),'url'=>array('mail/eventAdmin/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('mail','Просмотреть событие'),'url'=>array('/mail/eventAdmin/view','id'=>$model->id)),
    array('icon'=> 'plus-sign', 'label' =>  Yii::t('mail','Добавить  шаблон'),'url'=>array('/mail/templateAdmin/create/','eid' => $model->id)),
    array('icon'=>'remove', 'label' =>  Yii::t('mail','Удалить  событие'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=> Yii::t('mail','Вы уверены, что хотите удалить?'))),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('mail','Просмотр почтового события');?><br /><small style='margin-left:-10px;'>&laquo;<?php echo  $model->name; ?>&raquo;</small></h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'code',
        'name',
        'description',
    ),
)); ?>
