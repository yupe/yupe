<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array('admin'),
    Yii::t('queue','Задания') => array('index'),
    $model->id=> array('view','id'=> $model->id),
    Yii::t('queue','Редактирование'),
);
$this->pageTitle   = Yii::t('queue',"Задания - редактирование");
$this->menu        = array(
    array('icon'  => 'list-alt',
          'label' => Yii::t('queue','Список заданий'),
          'url'   => array('/queue/default/index')),
    array('icon'  => 'plus-sign',
          'label' => Yii::t('queue','Добавить задание'),
          'url'   => array('/queue/default/create')),
    array('icon'       => 'pencil white',
          'encodeLabel'=> false,
          'label'      => Yii::t('queue','Редактирование задания'),
          'url'        => array('/queue/default/update',
          'id'=> $model->id)),
    array('icon'       => 'eye-open',
          'encodeLabel'=> false,
          'label'      => Yii::t('queue','Просмотреть задание'),
          'url'        => array('/queue/default/view',
          'id'=> $model->id)
        ),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('queue','Редактирование задания');?><br/>
        <small style="margin-left: -10px;">&laquo; <?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>
<?php echo $this->renderPartial('_form', array('model'=> $model)); ?>