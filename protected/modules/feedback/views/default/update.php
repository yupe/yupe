<?php $this->pageTitle = Yii::t('feedback', 'Сообщения с сайта'); ?>

<?php
$this->breadcrumbs = array(
	$this->module->getCategory() => array('admin'),
    Yii::t('feedback', 'Сообщения с сайта') => array('admin'),
    $model->theme => array('view', 'id' => $model->id),
    Yii::t('feedback', 'Изменить'),
);

$this->menu = array(
    array('icon' => 'list-alt','label' => Yii::t('feedback', 'Управление сообщениями'), 'url' => array('/feedback/default/admin')),
    array('icon' => 'plus-sign','label' => Yii::t('feedback', 'Добавить сообщение'), 'url' => array('/feedback/default/create')),
    array('icon' => 'pencil white','label' => Yii::t('feedback', 'Редактирование сообщения'), 'url' => array('/feedback/default/update', 'id' => $model->id)),
    array('icon' => 'eye-open','label' => Yii::t('feedback', 'Просмотреть данное сообщение'), 'url' => array('/feedback/default/view', 'id' => $model->id)),
    array('icon' => 'envelope','label' => Yii::t('feedback', 'Ответить на сообщение'), 'url' => array('/feedback/default/answer', 'id' => $model->id)),
    array('icon' => 'trash', 'label' => Yii::t('feedback', 'Удалить сообщение'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('delete', 'id' => $model->id),
                'confirm' => Yii::t('blog', 'Вы уверены, что хотите удалить сообщение?')
            )),
);
?>

<h1><?php echo Yii::t('feedback', 'Редактировать сообщение с сайта '); ?> <small>#<?php echo $model->id; ?></small></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>