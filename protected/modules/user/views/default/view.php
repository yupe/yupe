<?php $this->pageTitle = Yii::t('user', 'Просмотр пользователя'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('index'),
    $model->nickName,
);

$this->menu = array(
    array('label' => Yii::t('user', 'Список пользователей'), 'url' => array('index')),
    array('label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('create')),
    array('label' => Yii::t('user', 'Редактирование пользователя'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('user', 'Удалить пользователя'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => Yii::t('user', 'Управление пользователями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('user', 'Просмотр пользователя')?>
    "<?php echo $model->getFullName(); ?>
    (<?php echo $model->nickName;?>)"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        'creationDate',
                                                        'changeDate',
                                                        'firstName',
                                                        'lastName',
                                                        'nickName',
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
                                                            'name' => 'accessLevel',
                                                            'value' => $model->getAccessLevel()
                                                        ),
                                                        'lastVisit',
                                                        'registrationDate',
                                                        'registrationIp',
                                                        'activationIp',
                                                    ),
                                               )); ?>
