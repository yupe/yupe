<?php
    $this->breadcrumbs = array(       
        Yii::t('QueueModule.queue', 'Tasks') => array('/queue/queueBackend/index'),
        Yii::t('QueueModule.queue', 'Creation'),
    );

    $this->pageTitle = Yii::t('QueueModule.queue', 'Tasks - creating');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('QueueModule.queue', 'Task list'), 'url' => array('/queue/queueBackend/index')),
        array('icon' => 'plus-sign', 'label' =>  Yii::t('QueueModule.queue', 'Task creation'), 'url' => array('/queue/queueBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('QueueModule.queue', 'Tasks'); ?>
        <small><?php echo Yii::t('QueueModule.queue', 'creation'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>