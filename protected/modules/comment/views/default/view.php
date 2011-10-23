<?php
$this->breadcrumbs = array(
    $this->getModule('category')->getCategory() => array(''),
    Yii::t('comment', 'Комментарии') => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => Yii::t('comment', 'Список комментариев'), 'url' => array('index')),
    array('label' => Yii::t('comment', 'Добавить комментарий'), 'url' => array('create')),
    array('label' => Yii::t('comment', 'Редактировать комментарий'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('comment', 'Удалить комментарий'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
    array('label' => Yii::t('comment', 'Управление комментариями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('comment', 'Просмотр комментария');?>
    #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        'model',
                                                        'model_id',
                                                        'creation_date',
                                                        'name',
                                                        'email',
                                                        'url',
                                                        'text',
                                                        array(
                                                            'name' => 'status',
                                                            'value' => $model->getStatus()
                                                        ),
                                                        'ip',
                                                    ),
                                               )); ?>
