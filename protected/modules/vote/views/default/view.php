<?php
    $this->breadcrumbs = array(
        $this->getModule('vote')->getCategory() => array(),
        Yii::t('vote', 'Голосование') => array('/vote/default/index'),
        $model->id,
    );

    $this->menu = array(
        array('label' => Yii::t('vote', 'Управление голосами'), 'url' => array('/vote/default/index')),
        array('label' => Yii::t('vote', 'Добавить голос'), 'url' => array('/vote/default/create')),
        array('label' => Yii::t('vote', 'Просмотреть голос'), 'url' => array('/vote/default/view', 'id' => $model->id)),
        array('label' => Yii::t('vote', 'Редактировать голос'), 'url' => array('/vote/default/update', 'id' => $model->id)),
        array('label' => Yii::t('vote', 'Удалить голос'), 'url' => '#', 'linkOptions' => array(
            'submit'  => array('/vote/default/delete', 'id' => $model->id),
            'confirm' => 'Подтверждаете удаление ?',
        )),
    );
?>

<h1><?php echo Yii::t('vote', 'Просмотр голоса');?> № <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'model',
        'model_id',
        'user_id',
        'creation_date',
        'value',
        ),
)); ?>
