<?php $this->pageTitle = Yii::t('user', 'Редактирование пользователя'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('index'),
    $model->nick_name => array('view', 'id' => $model->id),
    Yii::t('user', 'Редактирование'),
);

$this->menu = array(
    array('label' => Yii::t('user', 'Список пользователей'), 'url' => array('index')),
    array('label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('create')),
    array('label' => Yii::t('user', 'Просмотр пользователя'), 'url' => array('view', 'id' => $model->id)),
    array('label' => Yii::t('user', 'Управление пользователями'), 'url' => array('admin')),
    array('label' => Yii::t('user', 'Изменить пароль'), 'url' => array('changepassword', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('user', 'Редактирование пользователя')?>
    "<?php echo $model->nick_name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>