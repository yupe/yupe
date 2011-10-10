<?php $this->pageTitle = Yii::t('feedback', 'Сообщения с сайта'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('feedback', 'Сообщения с сайта') => array('admin'),
    $model->theme,
);

$this->menu = array(
    array('label' => Yii::t('feedback', 'Управление сообщениями'), 'url' => array('admin')),
    array('label' => Yii::t('feedback', 'Добавить сообщение'), 'url' => array('create')),
    array('label' => Yii::t('feedback', 'Список сообщений'), 'url' => array('index')),
    array('label' => Yii::t('feedback', 'Изменить данное сообщение'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('feedback', 'Удалить данное сообщение'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление сообщения ?')),
    array('label' => Yii::t('feedback', 'Ответить на сообщение'), 'url' => array('answer', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('feedback', 'Просмотр сообщения с сайта');?>
    #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        'creation_date',
                                                        'change_date',
                                                        'name',
                                                        'email',
                                                        'theme',
                                                        'text',
                                                        array(
                                                            'name' => 'type',
                                                            'value' => $model->getType()
                                                        ),
                                                        array(
                                                            'name' => 'status',
                                                            'value' => $model->getStatus()
                                                        ),
                                                        'answer',
                                                        'answer_date',
                                                        array(
                                                            'name' => 'is_faq',
                                                            'value' => $model->getIsFaq()
                                                        ),
                                                        'ip',
                                                    ),
                                               )); ?>
