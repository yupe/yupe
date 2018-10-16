<?php
$this->breadcrumbs = [
    Yii::t('QueueModule.queue', 'Tasks') => ['/queue/queueBackend/index'],
    $model->id                           => ['view', 'id' => $model->id],
    Yii::t('QueueModule.queue', 'Edit'),
];

$this->pageTitle = Yii::t('QueueModule.queue', 'Tasks - edit');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('QueueModule.queue', 'Task list'),
        'url'   => ['/queue/queueBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('QueueModule.queue', 'Create task'),
        'url'   => ['/queue/queueBackend/create']
    ],
    ['label' => Yii::t('QueueModule.queue', 'Task') . ' «' . $model->id . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('QueueModule.queue', 'Edit task.'),
        'url'   => [
            '/queue/queueBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('QueueModule.queue', 'Show task'),
        'url'   => [
            '/queue/queueBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('QueueModule.queue', 'Remove task'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/queue/queueBackend/delete', 'id' => $model->id],
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('QueueModule.queue', 'Do you really want to delete?'),
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('QueueModule.queue', 'Edit task'); ?><br/>
        <small>&laquo;<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
