<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array('admin'),
    'Задания' => array('index'),
    $model->id=> array('view',
        'id'=> $model->id),
    'Редактирование',
);
$this->pageTitle   = "задания - редактирование";
$this->menu        = array(
    array('icon'  => 'list-alt',
          'label' => 'Управление заданиями',
          'url'   => array('/queue/default/index')),
    array('icon'  => 'file',
          'label' => 'Добавить задание',
          'url'   => array('/queue/default/create')),
    array('icon'       => 'pencil white',
          'encodeLabel'=> false,
          'label'      => 'Редактирование задания',
          'url'        => array('/queue/default/update',
              'id'=> $model->id)),
    array('icon'       => 'eye-open',
          'encodeLabel'=> false,
          'label'      => 'Просмотреть задание',
          'url'        => array('/queue/default/view',
              'id'=> $model->id)),
);
?>
<div class="page-header">
    <h1>Редактирование задание<br/>
        <small style="margin-left: -10px;">&laquo; <?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>
<?php echo $this->renderPartial('_form', array('model'=> $model)); ?>