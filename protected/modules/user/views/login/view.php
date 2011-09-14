<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/admin/'),
    Yii::t('user', 'Авторизационыые данные') => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => Yii::t('user', 'Управление'), 'url' => array('admin')),
    array('label' => Yii::t('user', 'Список'), 'url' => array('index')),
    array('label' => Yii::t('user', 'Редактировать'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('user', 'Удалить'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('user', 'Подтверждаете удаление ?'))),
);
?>

<h1><?php echo Yii::t('user', 'Просмотр');?> #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        array(
                                                            'name' => 'userId',
                                                            'value' => $model->user->getFullName() . " ({$model->user->nickName})"
                                                        ),
                                                        'identityId',
                                                        'type',
                                                        'creationDate',
                                                    ),
                                               )); ?>
