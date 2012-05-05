<?php $this->pageTitle = Yii::t('feedback', 'Сообщения с сайта'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('feedback', 'Сообщения с сайта') => array('admin'),
    $model->theme => array('view', 'id' => $model->id),
    Yii::t('feedback', 'Изменить'),
);

$this->menu = array(
    array('label' => Yii::t('feedback', 'Управление сообщениями'), 'url' => array('/feedback/default/admin')),
    array('label' => Yii::t('feedback', 'Добавить сообщение'), 'url' => array('/feedback/default/create')),
    array('label' => Yii::t('feedback', 'Редактирование сообщения'), 'url' => array('/feedback/default/update', 'id' => $model->id)),
    array('label' => Yii::t('feedback', 'Просмотреть данное сообщение'), 'url' => array('/feedback/default/view', 'id' => $model->id)),
    array('label' => Yii::t('feedback', 'Ответить на сообщение'), 'url' => array('/feedback/default/answer', 'id' => $model->id))
);
?>

<h1><?php echo Yii::t('feedback', 'Редактировать сообщение с сайта ')?>
    #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>