<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array('admin'),
    'Задания'=> array('index'),
    $model->id,
);
$this->pageTitle   = "задания - просмотр";
$this->menu        = array(
    array('icon'  => 'list-alt',
          'label' => 'Управление заданиями',
          'url'   => array('/queue/default/index')),
    array('icon'  => 'file',
          'label' => 'Добавить задание',
          'url'   => array('/queue/default/create')),
    array('icon'  => 'pencil',
          'label' => 'Редактировать задание',
          'url'   => array('/queue/default/update',
              'id'=> $model->id)),
    array('icon'       => 'eye-open white',
          'encodeLabel'=> false,
          'label'      => 'Просмотр задание<br /><span class="label" style="font-size: 80%; margin-left:20px;">' . mb_substr($model->id, 0, 32) . "</span>",
          'url'        => array('/queue/default/view',
              'id'=> $model->id)),
    array('icon'       => 'remove',
          'label'      => 'Удалить задание',
          'url'        => '#',
          'linkOptions'=> array('submit' => array('delete',
              'id'=> $model->id),
                                'confirm'=> 'Вы уверены, что хотите удалить?')),
);
?>
<div class="page-header">
    <h1>Просмотр задание<br/>
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
