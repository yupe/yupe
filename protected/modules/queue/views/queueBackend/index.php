<?php
$this->breadcrumbs = [
    Yii::t('QueueModule.queue', 'Tasks') => ['/queue/queueBackend/index'],
    Yii::t('QueueModule.queue', 'Management'),
];

$this->pageTitle = Yii::t('QueueModule.queue', 'Tasks - manage');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('QueueModule.queue', 'Task list'),
        'url'   => ['/queue/queueBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('QueueModule.queue', 'Task creation'),
        'url'   => ['/queue/queueBackend/create']
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('QueueModule.queue', 'Tasks'); ?>
        <small><?php echo Yii::t('QueueModule.queue', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('QueueModule.queue', 'Find tasks'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('queue-grid', {
            data: $(this).serialize()
        });

        return false;
    });
"
    );
    $this->renderPartial('_search', ['model' => $model]);
    ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'           => 'queue-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => [
            'id',
            [
                'name'   => 'worker',
                'value'  => '$data->getWorkerName()',
                'filter' => Yii::app()->getModule('queue')->getWorkerNamesMap()
            ],
            'create_time',
            'start_time',
            'complete_time',
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'priority',
                'url'     => $this->createUrl('/queue/queueBackend/inline'),
                'source'  => $model->getPriorityList(),
                'options' => [
                    Queue::PRIORITY_HIGH   => ['class' => 'label-warning'],
                    Queue::PRIORITY_LOW    => ['class' => 'label-default'],
                    Queue::PRIORITY_NORMAL => ['class' => 'label-info'],
                ],
            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/queue/queueBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Queue::STATUS_COMPLETED => ['class' => 'label-success'],
                    Queue::STATUS_ERROR     => ['class' => 'label-danger'],
                    Queue::STATUS_NEW       => ['class' => 'label-info'],
                    Queue::STATUS_PROGRESS  => ['class' => 'label-warning'],
                ],
            ],
            'notice',
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
