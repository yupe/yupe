<?php
$this->breadcrumbs = array(
    $this->getModule('vote')->getCategory() => array(''),
    Yii::t('vote', 'Голосование') => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => Yii::t('vote', 'Список голосов'), 'url' => array('index')),
    array('label' => Yii::t('vote', 'Добавить голос'), 'url' => array('create')),
    array('label' => Yii::t('vote', 'Редактировать голос'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('vote', 'Удалить голос'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
    array('label' => Yii::t('vote', 'Управление голосами'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('vote', 'Просмотр голоса');?>
    № <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        'model',
                                                        'model_id',
                                                        'user_id',
                                                        'creation_date',
                                                        'value',
                                                    ),
                                               )); ?>
