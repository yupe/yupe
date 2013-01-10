<?php
$this->breadcrumbs=array(
    $this->module->getCategory() => array('index'),
    Yii::t('MailModule.mail','Почтовые события')=>array('/mail/eventAdmin/'),
    Yii::t('MailModule.mail','Почтовые шаблоны')=>array('index'),
    $model->name,
);
$this-> pageTitle = Yii::t('MailModule.mail','Просмотр почтового шаблона');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail','Список шаблонов'),'url'=>array('/mail/templateAdmin/index')),
    array('icon'=> 'plus-sign', 'label' =>  Yii::t('MailModule.mail','Добавление шаблона'),'url'=>array('/mail/templateAdmin/create')),
    array('icon'=>'pencil','encodeLabel'=> false, 'label' => Yii::t('MailModule.mail','Редактирование шаблона'),'url'=>array('/mail/templateAdmin/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('MailModule.mail','Просмотреть шаблон'),'url'=>array('/mail/templateAdmin/view','id'=>$model->id)),
    array('icon'=>'remove', 'label' =>  Yii::t('MailModule.mail','Удалить шаблон'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=> Yii::t('MailModule.mail','Вы уверены, что хотите удалить?'))),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail','Просмотр почтового шаблона');?><br /><small style='margin-left:-10px;'>&laquo;<?php echo  $model->name; ?>&raquo;</small></h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'code',
        array(
            'name'  => 'event_id',
            'value' => $model->event->name,
        ),
        'name',
        'description',
        'from',
        'to',
        'theme',
        'body',
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
    ),
)); ?>
