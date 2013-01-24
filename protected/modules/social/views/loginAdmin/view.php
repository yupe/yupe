<?php
    $this->breadcrumbs = array(
        $this->getModule('social')->getCategory() => array(),
        Yii::t('social', 'Социализация') => array('/social/default/index'),
        Yii::t('social', 'Авторизационные данные') => array('/social/default/index'),
        $model->id,
    );

    $this->menu = array(
        array('label' => Yii::t('social', 'Управление'), 'url' => array('/social/default/index')),
        array('label' => Yii::t('social', 'Просмотреть'), 'url' => array('/social/default/view', 'id' => $model->id)),
        array('label' => Yii::t('social', 'Редактировать'), 'url' => array('/social/default/update', 'id' => $model->id)),
        array('label' => Yii::t('social', 'Удалить'), 'url' => '#', 'linkOptions' => array(
            'submit'  => array('/social/default/delete', 'id' => $model->id),
            'confirm' => Yii::t('Social.social', 'Подтверждаете удаление ?'),
        )),
    );
?>

<h1><?php echo Yii::t('social', 'Просмотр'); ?> #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        array(
            'name'  => 'user_id',
            'value' => $model->user->getFullName() . " ({$model->user->nick_name})"
        ),
        'identity_id',
        'type',
        'creation_date',
    ),
)); ?>
