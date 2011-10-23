<?php
$this->breadcrumbs = array(
    $this->getModule('social')->getCategory() => array(''),
    Yii::t('social', 'Социализация') => array('/social/default/'),
    Yii::t('social', 'Авторизационные данные') => array('admin'),
    $model->id => array('view', 'id' => $model->id),
    Yii::t('social', 'Редактирование'),
);

$this->menu = array(
    array('label' => Yii::t('social', 'Управление'), 'url' => array('admin')),
    array('label' => Yii::t('social', 'Список'), 'url' => array('index')),
    array('label' => Yii::t('social', 'Просмотреть'), 'url' => array('view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('social', 'Редактирование');?>
    #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>