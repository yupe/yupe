<?php $this->pageTitle = Yii::t('user', 'Редактирование пользователя'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('index'),
    $model->nick_name => array('view', 'id' => $model->id),
    Yii::t('user', 'Редактирование'),
);

$this->menu = array(
    array('icon' => 'th-large', 'label' => Yii::t('user', 'Управление пользователями'), 'url' => array('/user/default/admin')),
    array('icon' => 'th-list', 'label' => Yii::t('user', 'Список пользователей'), 'url' => array('/user/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
    array('label' => Yii::t('user', 'Пользователь')),
    array('icon' => 'pencil white', 'label' => Yii::t('user', 'Редактирование пользователя'), 'url' => array('/user/default/update', 'id' => $model->id)),
    array('icon' => 'user', 'label' => Yii::t('user', 'Просмотр пользователя'), 'url' => array('/user/default/view', 'id' => $model->id)),
    array('icon' => 'lock', 'label' => Yii::t('user', 'Изменить пароль пользователя'), 'url' => array('/user/default/changepassword', 'id' => $model->id)),
    array('icon' => 'trash', 'label' => Yii::t('user', 'Удалить пользователя'), 'url' => '#', 'linkOptions' => array(
        'submit' => array('/user/default/delete', 'id' => $model->id),
        'confirm' => 'Подтверждаете удаление ?'),
    ),
    array('label' => Yii::t('user', 'Восстановления паролей')),
    array('icon' => 'th-large', 'label' => Yii::t('user', 'Управление восстановлением паролей'), 'url' => array('/user/recoveryPassword/admin')),
    array('icon' => 'th-list', 'label' => Yii::t('user', 'Список восстановлений'), 'url' => array('/user/recoveryPassword/index')),
);
?>

<h1><?php echo Yii::t('user', 'Редактирование пользователя')?>
    "<?php echo $model->getFullName(); ?> (<?php echo $model->nick_name; ?>)" </h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>