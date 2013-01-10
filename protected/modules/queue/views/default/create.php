<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('queue')->getCategory() => array(),
        Yii::t('QueueModule.queue', 'Задания') => array('/queue/default/index'),
        Yii::t('QueueModule.queue', 'Добавление'),
    );

    $this->pageTitle = Yii::t('QueueModule.queue', 'Задания - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('QueueModule.queue', 'Список заданий'), 'url' => array('/queue/default/index')),
        array('icon' => 'plus-sign', 'label' =>  Yii::t('QueueModule.queue', 'Добавление задания'), 'url' => array('/queue/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('QueueModule.queue', 'Задания'); ?>
        <small><?php echo Yii::t('QueueModule.queue', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>