<?php $this->pageTitle = Yii::t('user', 'Редактирование пользователя'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/index'),
    $model->nick_name => array('/user/default/view', 'id' => $model->id),
    Yii::t('user', 'Редактирование'),
);

$this->menu = array(
    array('label' => Yii::t('user', 'Пользователи')),
    array('icon' => 'list', 'label' => Yii::t('user', 'Управление пользователями'), 'url' => array('/user/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
    array('label' => Yii::t('user', 'Пользователь')),
    array('icon' => 'pencil', 'label' => Yii::t('user', 'Редактирование пользователя'), 'url' => array('/user/default/update', 'id' => $model->id)),
    array('icon' => 'eye-open', 'label' => Yii::t('user', 'Просмотр пользователя'), 'url' => array('/user/default/view', 'id' => $model->id)),
    array('icon' => 'lock', 'label' => Yii::t('user', 'Изменить пароль пользователя'), 'url' => array('/user/default/changepassword', 'id' => $model->id)),
    array('icon' => 'trash', 'label' => Yii::t('user', 'Удалить пользователя'), 'url' => '#', 'linkOptions' => array(
        'submit' => array('/user/default/delete', 'id' => $model->id),
        'confirm' => 'Подтверждаете удаление ?'),
    ),
    array('label' => Yii::t('user', 'Восстановления паролей')),
    array('icon' => 'th-large', 'label' => Yii::t('user', 'Восстановления паролей'), 'url' => array('/user/recoveryPassword/index')),
);
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('user', 'Редактирование пользователя'); ?><br />
        <small>&laquo;<?php echo $model->getFullName(); ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>