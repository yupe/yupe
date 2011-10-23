<?php $this->pageTitle = Yii::t('user', 'Просмотр регистрации'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/admin/'),
    Yii::t('user', 'Регистрации') => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => Yii::t('user', 'Список регистраций'), 'url' => array('index')),
    array('label' => Yii::t('user', 'Изменить регистрацию'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('user', 'Удалить регистрацию'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
    array('label' => Yii::t('user', 'Управление регистрациями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('user', 'Просмотр регистрации') ?>
    #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        'creation_date',
                                                        'nick_name',
                                                        'email',
                                                        'salt',
                                                        'password',
                                                        'code',
                                                    ),
                                               )); ?>
