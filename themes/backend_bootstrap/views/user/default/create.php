<?php $this->pageTitle = Yii::t('user', 'Добавление пользователя'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('index'),
    Yii::t('user', 'Добавление пользователя'),
);

$this->menu = array(
    array('icon' => 'th-large', 'label' => Yii::t('user', 'Управление пользователями'), 'url' => array('/user/default/admin')),
    array('icon' => 'th-list', 'label' => Yii::t('user', 'Список пользователей'), 'url' => array('/user/default/index')),
    array('icon' => 'plus-sign white', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
    array('label' => Yii::t('user', 'Восстановления паролей')),
    array('icon' => 'th-large', 'label' => Yii::t('user', 'Управление восстановлением паролей'), 'url' => array('/user/recoveryPassword/admin')),
    array('icon' => 'th-list', 'label' => Yii::t('user', 'Список восстановлений'), 'url' => array('/user/recoveryPassword/index')),
    array('label' => Yii::t('user', 'Остальное')),
    array('icon' => 'retweet', 'label' => Yii::t('user', 'Сбросить сессии пользователей'), 'url' => array('/user/default/resetsessions')),
);
?>

<h1><?php echo Yii::t('user', 'Добавление пользователя')?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>