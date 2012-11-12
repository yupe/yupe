<?php
$this->breadcrumbs = array(
    $this->getModule('comment')->getCategory() => array(''),
    Yii::t('comment', 'Комментарии') => array('admin'),
    $model->id,
);

$this->menu = array(
    array('icon'=> 'list-alt','label' => Yii::t('comment', 'Список комментариев'), 'url' => array('admin')),
    array('icon'=> 'plus-sign','label' => Yii::t('comment', 'Добавить комментарий'), 'url' => array('create')),
    array('icon'=> 'pencil','label' => Yii::t('comment', 'Редактировать комментарий'), 'url' => array('update', 'id' => $model->id)),
    array('icon'=> 'remove','label' => Yii::t('comment', 'Удалить комментарий'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
);
?>

<div class="page-header">
    <h1><?php echo Yii::t('comment','Просмотр комментария');?><br /><small style='margin-left:-10px;'>&laquo;<?php echo  $model->id; ?>&raquo;</small></h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'model',
        'model_id',
        'creation_date',
        'name',
        'email',
        'url',
        'text',
        array(
            'name' => 'status',
            'value' => $model->getStatus()
        ),
        'ip',
        ),
)); ?>
