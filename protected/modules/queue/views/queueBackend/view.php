<?php
$this->breadcrumbs = [
    Yii::t('QueueModule.queue', 'Tasks') => ['/queue/queueBackend/index'],
    $model->id,
];

$this->pageTitle = Yii::t('QueueModule.queue', 'Tasks - show');

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
        <?php echo Yii::t('QueueModule.queue', 'View task'); ?><br/>
        <small>&laquo;<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'id',
            [
                'name'  => 'worker',
                'value' => $model->getWorkerName()
            ],
            'create_time',
            'task',
            'start_time',
            'complete_time',
            [
                'name'  => 'priority',
                'value' => $model->getPriority()
            ],
            [
                'name'  => 'status',
                'value' => $model->getStatus()
            ],
            'notice',
        ],
    ]
); ?>
