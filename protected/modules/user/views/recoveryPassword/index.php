<?php $this->pageTitle = Yii::t('user', 'Восстановление пароля'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/admin/'),
    Yii::t('user', 'Восстановление пароля'),
);

$this->menu = array(
    array('icon' => 'th-large', 'label' => Yii::t('user', 'Управление пользователями'), 'url' => array('/user/default/admin')),
    array('icon' => 'th-list', 'label' => Yii::t('user', 'Список пользователей'), 'url' => array('/user/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
    array('label' => Yii::t('user', 'Восстановления паролей')),
    array('icon' => 'th-large', 'label' => Yii::t('user', 'Управление восстановлением паролей'), 'url' => array('/user/recoveryPassword/admin')),
    array('icon' => 'th-list white', 'label' => Yii::t('user', 'Список восстановлений'), 'url' => array('/user/recoveryPassword/index')),
);
?>

<h1><?php echo Yii::t('user', 'Восстановление пароля');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>
