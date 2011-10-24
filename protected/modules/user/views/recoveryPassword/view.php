<?php $this->pageTitle = Yii::t('user', 'Восстановление пароля'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/admin/'),
    Yii::t('user', 'Восстановление пароля') => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => Yii::t('user', 'Список восстановлений пароля'), 'url' => array('index')),    
    array('label' => Yii::t('user', 'Удалить восстановление пароля'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
    array('label' => Yii::t('user', 'Управление восстановлениями пароля'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('user', 'Просмотр восстановления пароля')?>
    #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        array(
                                                            'name' => 'user_id',
                                                            'value' => $model->user->nick_name
                                                        ),
                                                        'creation_date',
                                                        'code',
                                                    ),
                                               )); ?>
