<?php
$this->pageTitle = Yii::t('user', 'Просмотр пользователя');

$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/index'),
    $model->nick_name,
);

$this->menu = array(
    array('label' => Yii::t('user', 'Пользователи')),
    array('icon' => 'list', 'label' => Yii::t('user', 'Управление пользователями'), 'url' => array('/user/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
    array('label' => Yii::t('user', 'Пользователь') . ' «' . mb_substr($model->nick_name, 0, 32) . '»'),
    array('icon' => 'pencil', 'label' => Yii::t('user', 'Редактирование пользователя'), 'url' => array('/user/default/update', 'id' => $model->id)),
    array('icon' => 'eye-open', 'label' => Yii::t('user', 'Просмотр пользователя'), 'url' => array('/user/default/view', 'id' => $model->id)),
    array('icon' => 'lock', 'label' => Yii::t('user', 'Изменить пароль пользователя'), 'url' => array('/user/default/changepassword', 'id' => $model->id)),
    array('icon' => 'trash', 'label' => Yii::t('user', 'Удалить пользователя'), 'url' => '#', 'linkOptions' => array(
        'submit' => array('/user/default/delete', 'id' => $model->id),
        'confirm' => 'Подтверждаете удаление ?'),
    ),
    array('label' => Yii::t('user', 'Восстановления паролей')),
    array('icon' => 'list', 'label' => Yii::t('user', 'Восстановления паролей'), 'url' => array('/user/recoveryPassword/index')),);
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('user', 'Просмотр пользователя'); ?><br />
        <small>&laquo;<?php echo $model->nick_name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'creation_date',
        'change_date',
        'first_name',
        'last_name',
        'nick_name',
        'email',
        'location',
        'site',
        'birth_date',
        'about',
        array(
            'name'  => 'gender',
            'value' => $model->getGender(),
        ),
        'password',
        'salt',
        'activate_key',
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
        array(
            'name'  => 'access_level',
            'value' => $model->getAccessLevel(),
        ),
        array(
            'name'  => 'email_confirm',
            'value' => $model->getEmailConfirmStatus(),
        ),
        'last_visit',
        'registration_date',
        'registration_ip',
        'activation_ip',
    ),
));
?>