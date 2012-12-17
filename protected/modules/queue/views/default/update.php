<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('queue')->getCategory() => array(),
        Yii::t('queue', 'Задания') => array('/queue/default/index'),
        $model->id => array('view', 'id' => $model->id),
        Yii::t('queue', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('queue', 'Задания - редактирование');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('queue', 'Список заданий'), 'url' => array('/queue/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('queue', 'Добавить задание'), 'url' => array('/queue/default/create')),
        array('label' => Yii::t('blog', 'Задание') . ' «' . $model->id . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('queue', 'Редактировать задание'), 'url' => array(
            '/queue/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('queue', 'Просмотр задание'), 'url' => array(
            '/queue/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('queue','Удалить задание'), 'url' => '#', 'linkOptions'=> array(
            'submit' => array('/queue/default/delete', 'id' => $model->id),
            'confirm'=> Yii::t('queue', 'Вы уверены, что хотите удалить?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('queue', 'Редактирование задания'); ?><br/>
        <small>&laquo; <?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>