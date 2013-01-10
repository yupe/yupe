<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('queue')->getCategory() => array(),
        Yii::t('QueueModule.queue', 'Задания') => array('/queue/default/index'),
        Yii::t('QueueModule.queue', 'Управление'),
    );

    $this->pageTitle = Yii::t('QueueModule.queue', 'Задания - управление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('QueueModule.queue', 'Список заданий'), 'url' => array('/queue/default/index')),
        array('icon' => 'plus-sign', 'label' =>  Yii::t('QueueModule.queue', 'Добавление задания'), 'url' => array('/queue/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('QueueModule.queue', 'Задания'); ?>
        <small><?php echo Yii::t('QueueModule.queue', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('QueueModule.queue', 'Поиск заданий'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('queue-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('QueueModule.queue', 'В данном разделе представлены средства управления заданиями'); ?></p>

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'queue-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        array(
            'name'   => 'worker',
            'value'  => 'isset(Yii::app()->queue->workerNamesMap[$data->worker]) ? Yii::app()->queue->workerNamesMap[$data->worker] : $data->worker',
            'filter' => CHtml::activeDropDownList($model, 'worker', Yii::app()->queue->workerNamesMap)
        ),
        'create_time',
        'start_time',
        'complete_time',
        array(
            'name'  => 'priority',
            'type'  => 'raw',
            'value' => "'<span class=\"label label-'.(\$data->priority?((\$data->priority==Queue::PRIORITY_HIGH)?'warning':((\$data->priority==Queue::PRIORITY_LOW)?'success':'error')):'info').'\">'.\$data->getPriority().'</span>'",
            'filter' => CHtml::activeDropDownList($model, 'priority', $model->priorityList),
        ),
        array(
            'name'  => 'status',
            'type'  => 'raw',
            'value' => "'<span class=\"label label-'.(\$data->status?((\$data->status==1)?'warning':((\$data->status==3)?'success':'default')):'info').'\">'.\$data->getStatus().'</span>'",
            'filter' => CHtml::activeDropDownList($model, 'status', $model->statusList),
        ),
        'notice',
        array(
            'class'=> 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>