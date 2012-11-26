<?php
$this->pageTitle = Yii::t('user', 'Восстановление пароля');

$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/index'),
    Yii::t('user', 'Восстановление пароля') => array('/user/recoveryPassword/index'),
    $model->id,
);

$this->menu = array(
    array('label' => Yii::t('user', 'Пользователи')),
    array('icon' => 'list', 'label' => Yii::t('user', 'Управление пользователями'), 'url' => array('/user/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
    array('label' => Yii::t('user', 'Восстановления паролей')),
    array('icon' => 'list', 'label' => Yii::t('user', 'Управление восстановлением паролей'), 'url' => array('/user/recoveryPassword/index')),
    array('icon' => 'trash', 'label' => Yii::t('user', 'Удалить восстановление пароля'), 'url' => '#', 'linkOptions' => array('submit' => array('/user/recoveryPassword/delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
);
?>

<h1><?php echo Yii::t('user', 'Просмотр восстановления пароля'); ?> #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        array(
            'name'  => 'user_id',
            'value' => $model->user->nick_name,
        ),
        'creation_date',
        'code',
    ),
)); ?>