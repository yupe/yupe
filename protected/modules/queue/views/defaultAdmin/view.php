<?php
    $this->breadcrumbs = array(
        $this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType()),
        Yii::t('QueueModule.queue', 'Задания') => array('/queue/defaultAdmin/index'),
        $model->id,
    );

    $this->pageTitle = Yii::t('QueueModule.queue', 'Задания - просмотр');

    $this->menu = array(
        array('label' => Yii::t('QueueModule.queue', 'Задания'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('QueueModule.queue', 'Список заданий'), 'url' => array('/queue/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' =>  Yii::t('QueueModule.queue', 'Добавление задания'), 'url' => array('/queue/defaultAdmin/create')),
        )),
        array('label' => Yii::t('blog', 'Задание') . ' «' . $model->id . '»', 'items' => array(
            array('icon' => 'pencil', 'label' => Yii::t('QueueModule.queue', 'Редактировать задание'), 'url' => array(
                '/queue/defaultAdmin/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('QueueModule.queue', 'Просмотр задание'), 'url' => array(
                '/queue/defaultAdmin/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('QueueModule.queue','Удалить задание'), 'url' => '#', 'linkOptions'=> array(
                'submit' => array('/queue/defaultAdmin/delete', 'id' => $model->id),
                'confirm'=> Yii::t('QueueModule.queue', 'Вы уверены, что хотите удалить?'),
            )),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('QueueModule.queue', 'Просмотр задания'); ?><br/>
        <small>&laquo;<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'      => $model,
    'attributes'=> array(
        'id',
        'worker',
        'create_time',
        'task',
        'start_time',
        'complete_time',
        array(
            'name'  => 'priority',
            'value' => $model->getPriority()
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus()
        ),
        'notice',
    ),
)); ?>