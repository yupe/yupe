<?php
    $this->breadcrumbs = array(
        $this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType()),
        Yii::t('QueueModule.queue', 'Задания') => array('/queue/defaultAdmin/index'),
        Yii::t('QueueModule.queue', 'Добавление'),
    );

    $this->pageTitle = Yii::t('QueueModule.queue', 'Задания - добавление');

    $this->menu = array(
       array('label' => Yii::t('QueueModule.queue', 'Задания'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('QueueModule.queue', 'Список заданий'), 'url' => array('/queue/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' =>  Yii::t('QueueModule.queue', 'Добавление задания'), 'url' => array('/queue/defaultAdmin/create')),
        ))
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('QueueModule.queue', 'Задания'); ?>
        <small><?php echo Yii::t('QueueModule.queue', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>