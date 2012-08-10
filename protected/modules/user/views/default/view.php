<?php

$this->pageTitle = Yii::t('user', 'Просмотр пользователя');

$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('admin'),
    $model->nick_name,
);

$this->menu = array(
    array('icon' => 'th-large', 'label' => Yii::t('user', 'Управление пользователями'), 'url' => array('/user/default/admin')),
    array('icon' => 'th-list', 'label' => Yii::t('user', 'Список пользователей'), 'url' => array('/user/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
    array('label' => Yii::t('user', 'Пользователь')),
    array('icon' => 'pencil', 'label' => Yii::t('user', 'Редактирование пользователя'), 'url' => array('/user/default/update', 'id' => $model->id)),
    array('icon' => 'user white', 'label' => Yii::t('user', 'Просмотр пользователя'), 'url' => array('/user/default/view', 'id' => $model->id)),
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

<h1><?php echo Yii::t('user', 'Просмотр пользователя'); ?> 
"<?php echo $model->getFullName(); ?> (<?php echo $model->nick_name; ?>)" </h1>

<?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
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
                'name' => 'gender',
                'value' => $model->getGender(),
            ),
            'password',
            'salt',
            'activate_key',
            array(
                'name' => 'status',
                'value' => $model->getStatus(),
            ),
            array(
                'name' => 'access_level',
                'value' => $model->getAccessLevel(),
            ),
            array(
                'name' => 'email_confirm',
                'value' => $model->getEmailConfirmStatus(),
            ),
            'last_visit',
            'registration_date',
            'registration_ip',
            'activation_ip',
        ),
    ));
?>
