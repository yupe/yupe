<?php
$this->breadcrumbs = array(
    Yii::t('QueueModule.queue', 'Tasks') => array('/queue/queueBackend/index'),
    $model->id                           => array('view', 'id' => $model->id),
    Yii::t('QueueModule.queue', 'Edit'),
);

$this->pageTitle = Yii::t('QueueModule.queue', 'Tasks - edit');

$this->menu = array(
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('QueueModule.queue', 'Task list'),
        'url'   => array('/queue/queueBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('QueueModule.queue', 'Create task'),
        'url'   => array('/queue/queueBackend/create')
    ),
    array('label' => Yii::t('QueueModule.queue', 'Task') . ' «' . $model->id . '»'),
    array(
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('QueueModule.queue', 'Edit task.'),
        'url'   => array(
            '/queue/queueBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('QueueModule.queue', 'Show task'),
        'url'   => array(
            '/queue/queueBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('QueueModule.queue', 'Remove task'),
        'url'         => '#',
        'linkOptions' => array(
            'submit'  => array('/queue/queueBackend/delete', 'id' => $model->id),
            'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('QueueModule.queue', 'Do you really want to delete?'),
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('QueueModule.queue', 'Edit task'); ?><br/>
        <small>&laquo;<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
