<?php $this->pageTitle = Yii::t('feedback', 'Сообщения с сайта'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('feedback', 'Сообщения с сайта') => array('admin'),
    $model->theme => array('view', 'id' => $model->id),
    Yii::t('feedback', 'Изменить'),
);

$this->menu = array(
    array('label' => Yii::t('feedback', 'Добавить сообщение'), 'url' => array('create')),
    array('label' => Yii::t('feedback', 'Управление сообщениями'), 'url' => array('admin')),
    array('label' => Yii::t('feedback', 'Список сообщений'), 'url' => array('index')),
    array('label' => Yii::t('feedback', 'Просмотреть данное сообщение'), 'url' => array('view', 'id' => $model->id)),
    array('label' => Yii::t('feedback', 'Ответить на сообщение'), 'url' => array('answer', 'id' => $model->id))
);
?>

<h1><?php echo Yii::t('feedback', 'Редактировать сообщение с сайта ')?>
    #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>