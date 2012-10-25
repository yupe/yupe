<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array('index'),
    Yii::t('queue','Задания')=> array('index'),
    $model->id,
);
$this->pageTitle   = Yii::t('queue',"Задания - просмотр");
$this->menu        = array(
    array('icon'  => 'list-alt',
          'label' => Yii::t('queue','Список заданий'),
          'url'   => array('/queue/default/index')),
    array('icon'  => 'plus-sign',
          'label' => Yii::t('queue','Добавить задание'),
          'url'   => array('/queue/default/create')),
    array('icon'  => 'pencil',
          'label' => Yii::t('queue','Редактировать задание'),
          'url'   => array('/queue/default/update',
          'id'=> $model->id)),
    array('icon'       => 'eye-open white',
          'encodeLabel'=> false,
          'label'      => Yii::t('queue','Просмотр задание'),
          'url'        => array('/queue/default/view',
          'id'=> $model->id)),
    array('icon'       => 'remove',
          'label'      => Yii::t('queue','Удалить задание'),
          'url'        => '#',
          'linkOptions'=> array('submit' => array('delete',
          'id'=> $model->id),
          'confirm'=> Yii::t('queue','Вы уверены, что хотите удалить?'))),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('queue','Просмотр задания');?><br/>
        <small style='margin-left:-10px;'>&laquo;<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'      => $model,
    'attributes'=> array(
        'id',
        'worker',
        'create_time',
        'task',
        'start_time',
        'complete_time',
        array(
            'name'  => 'priority',
            'value' => $model->getPriority()
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus()
        ),
        'notice',
    ),
)); ?>
