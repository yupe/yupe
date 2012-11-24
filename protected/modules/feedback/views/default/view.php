<?php $this->pageTitle = Yii::t('feedback', 'Сообщения с сайта'); ?>

<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array('/feedback/default/index'),
    Yii::t('feedback', 'Сообщения с сайта') => array('/feedback/default/index'),
    $model->theme,
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('feedback', 'Управление сообщениями'), 'url' => array('/feedback/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('feedback', 'Добавить сообщение'), 'url' => array('/feedback/default/create')),
    array('icon' => 'pencil', 'label' => Yii::t('feedback', 'Редактировать данное сообщение'), 'url' => array('/feedback/default/update', 'id' => $model->id)),
    array('icon' => 'eye-open white', 'label' => Yii::t('feedback', 'Просмотр сообщения'), 'url' => array('/feedback/default/view', 'id' => $model->id)),
    array('icon' => 'trash', 'label' => Yii::t('feedback', 'Удалить данное сообщение'), 'url' => '#', 'linkOptions' => array(
        'submit'  => array('delete', 'id' => $model->id),
        'confirm' => 'Подтверждаете удаление сообщения ?',
    )),
    array('icon' => 'envelope', 'label' => Yii::t('feedback', 'Ответить на сообщение'), 'url' => array('/feedback/default/answer', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('feedback', 'Просмотр сообщения с сайта'); ?> <small>#<?php echo $model->id; ?></small></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        array(
            'name'  => 'creation_date',
            'value' => Yii::app()->dateFormatter->formatDateTime($model->creation_date, 'short'),
        ),
        array(
            'name'  => 'change_date',
            'value' => Yii::app()->dateFormatter->formatDateTime($model->change_date, 'short'),
        ),
        'name',
        'email',
        'phone',
        'theme',
         array(
            'name' => 'text',
            'type' => 'raw'
        ),
        array(
            'name'  => 'type',
            'value' => $model->getType(),
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
        array(
            'name' => 'answer',
            'type' => 'raw'
        ),
        array(
            'name'  => 'answer_user',
            'value' => $model->getAnsweredUser(),
        ),
        array(
            'name'  => 'answer_date',
            'value' => ($model->answer_date != "0000-00-00 00:00:00") ? Yii::app()->dateFormatter->formatDateTime($model->answer_date, 'short') : "—",
        ),
        array(
            'name'  => 'is_faq',
            'value' => $model->getIsFaq(),
        ),
        'ip',
    ),
)); ?>