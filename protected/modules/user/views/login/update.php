<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/admin/'),
    Yii::t('user', 'Авторизационные данные') => array('admin'),
    $model->id => array('view', 'id' => $model->id),
    Yii::t('user', 'Редактирование'),
);

$this->menu = array(
    array('label' => Yii::t('user', 'Управление'), 'url' => array('admin')),
    array('label' => Yii::t('user', 'Список'), 'url' => array('index')),
    array('label' => Yii::t('user', 'Просмотреть'), 'url' => array('view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('user', 'Редактирование');?>
    #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>