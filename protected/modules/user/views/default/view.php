<?php $this->pageTitle = Yii::t('user', 'Просмотр пользователя'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('admin'),
    $model->nick_name,
);

$this->menu = array(
    array('label' => Yii::t('user', 'Список пользователей'), 'url' => array('index')),
    array('label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('create')),
    array('label' => Yii::t('user', 'Редактирование пользователя'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('user', 'Удалить пользователя'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
    array('label' => Yii::t('user', 'Управление пользователями'), 'url' => array('admin')),
    array('label' => Yii::t('user', 'Изменить пароль'), 'url' => array('changepassword', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('user', 'Просмотр пользователя')?>
    "<?php echo $model->getFullName(); ?>
    (<?php echo $model->nick_name;?>)"</h1>

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
                                                        array(
                                                            'name' => 'gender',
                                                            'value' => $model->getGender()
                                                        ),
                                                        'password',
                                                        'salt',
                                                        array(
                                                            'name' => 'status',
                                                            'value' => $model->getStatus()
                                                        ),
                                                        array(
                                                            'name' => 'access_level',
                                                            'value' => $model->getAccessLevel()
                                                        ),
                                                        'last_visit',
                                                        'registration_date',
                                                        'registration_ip',
                                                        'activation_ip',
                                                    ),
                                               )); ?>
