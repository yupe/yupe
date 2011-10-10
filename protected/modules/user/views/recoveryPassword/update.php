<?php $this->pageTitle = Yii::t('user', 'Восстановление пароля'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/admin/'),
    Yii::t('user', 'Восстановление пароля') => array('index'),
    $model->id => array('view', 'id' => $model->id),
    Yii::t('user', 'Изменение'),
);

$this->menu = array(
    array('label' => Yii::t('user', 'Список восстановлений пароля'), 'url' => array('index')),
    array('label' => Yii::t('user', 'Просмотреть восстановление пароля'), 'url' => array('view', 'id' => $model->id)),
    array('label' => Yii::t('user', 'Управление восстановлениями пароля'), 'url' => array('admin')),
);
?>

<h1>Update RecoveryPassword <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>