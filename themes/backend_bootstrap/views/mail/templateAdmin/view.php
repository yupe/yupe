<?php
$this->breadcrumbs=array(
    $this->module->getCategory() => array('admin'),
    'Почтовые шаблоны'=>array('index'),
    $model->name,
);
$this-> pageTitle ="почтовые шаблоны - просмотр";
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление почтовыми шаблонами'),'url'=>array('/mail/templateAdmin/index')),
    array('icon'=> 'file', 'label' =>  Yii::t('yupe','Добавление почтового шаблона'),'url'=>array('/mail/templateAdmin/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('yupe','Редактирование '). 'почтового шаблона<br /><span class="label" style="font-size: 80%; margin-left:20px;">'.mb_substr($model->name,0,32)."</span>",'url'=>array('mail/templateAdmin/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('yupe','Просмотреть '). 'почтовый шаблон','url'=>array('/mail/templateAdmin/view','id'=>$model->id)),
    array('icon'=>'remove', 'label' =>  Yii::t('yupe','Удалить почтовый шаблон'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=> Yii::t('yupe','Вы уверены, что хотите удалить?'))),
);
?>
<div class="page-header">
    <h1>Просмотр почтового шаблона<br /><small style='margin-left:-10px;'>&laquo;<?php echo  $model->name; ?>&raquo;</small></h1>
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
