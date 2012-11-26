<?php
$this->pageTitle = Yii::t('user', 'Добавление пользователя');

$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/index'),
    Yii::t('user', 'Добавление пользователя'),
);

$this->menu = array(
    array('label' => Yii::t('user', 'Пользователи')),
    array('icon' => 'list', 'label' => Yii::t('user', 'Управление пользователями'), 'url' => array('/user/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
    array('label' => Yii::t('user', 'Восстановления паролей')),
    array('icon' => 'list', 'label' => Yii::t('user', 'Управление восстановлением паролей'), 'url' => array('/user/recoveryPassword/index')),
);
?>

<h1><?php echo Yii::t('user', 'Добавление пользователя'); ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>