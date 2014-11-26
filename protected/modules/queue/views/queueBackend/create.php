<?php
$this->breadcrumbs = [
    Yii::t('QueueModule.queue', 'Tasks') => ['/queue/queueBackend/index'],
    Yii::t('QueueModule.queue', 'Creation'),
];

$this->pageTitle = Yii::t('QueueModule.queue', 'Tasks - creating');

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
        <small><?php echo Yii::t('QueueModule.queue', 'creation'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
