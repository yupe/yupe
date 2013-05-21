<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('queue')->getCategory() => array(),
        Yii::t('QueueModule.queue', 'Задания') => array('/queue/default/index'),
        $model->id => array('view', 'id' => $model->id),
        Yii::t('QueueModule.queue', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('QueueModule.queue', 'Задания - редактирование');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('QueueModule.queue', 'Список заданий'), 'url' => array('/queue/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('QueueModule.queue', 'Добавить задание'), 'url' => array('/queue/default/create')),
        array('label' => Yii::t('blog', 'Задание') . ' «' . $model->id . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('QueueModule.queue', 'Редактировать задание'), 'url' => array(
            '/queue/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('QueueModule.queue', 'Просмотр задание'), 'url' => array(
            '/queue/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('QueueModule.queue','Удалить задание'), 'url' => '#', 'linkOptions'=> array(
            'submit' => array('/queue/default/delete', 'id' => $model->id),
            'params' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'confirm'=> Yii::t('QueueModule.queue', 'Вы уверены, что хотите удалить?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('QueueModule.queue', 'Редактирование задания'); ?><br/>
        <small>&laquo; <?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
