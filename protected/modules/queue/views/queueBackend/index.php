<?php
$this->breadcrumbs = array(
    Yii::t('QueueModule.queue', 'Tasks') => array('/queue/queueBackend/index'),
    Yii::t('QueueModule.queue', 'Management'),
);

$this->pageTitle = Yii::t('QueueModule.queue', 'Tasks - manage');

$this->menu = array(
    array(
        'icon'  => 'glyphicon glyphicon-list-alt',
        'label' => Yii::t('QueueModule.queue', 'Task list'),
        'url'   => array('/queue/queueBackend/index')
    ),
    array(
        'icon'  => 'glyphicon glyphicon-plus-sign',
        'label' => Yii::t('QueueModule.queue', 'Task creation'),
        'url'   => array('/queue/queueBackend/create')
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('QueueModule.queue', 'Tasks'); ?>
        <small><?php echo Yii::t('QueueModule.queue', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="glyphicon glyphicon-search">&nbsp;</i>
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
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<p><?php echo Yii::t('QueueModule.queue', 'This section represent queue management system'); ?></p>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'queue-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            'id',
            array(
                'name'   => 'worker',
                'value'  => '$data->getWorkerName()',
                'filter' => Yii::app()->getModule('queue')->getWorkerNamesMap()
            ),
            'create_time',
            'start_time',
            'complete_time',
            array(
                'name'   => 'priority',
                'type'   => 'raw',
                'value'  => "'<span class=\"label label-'.(\$data->priority?((\$data->priority==Queue::PRIORITY_HIGH)?'warning':((\$data->priority==Queue::PRIORITY_LOW)?'success':'danger')):'info').'\">'.\$data->getPriority().'</span>'",
                'filter' => $model->getPriorityList(),
            ),
            array(
                'name'   => 'status',
                'type'   => 'raw',
                'value'  => "'<span class=\"label label-'.(\$data->status?((\$data->status==1)?'warning':((\$data->status==3)?'success':'default')):'info').'\">'.\$data->getStatus().'</span>'",
                'filter' => $model->getStatusList(),
            ),
            'notice',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
