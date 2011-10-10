<?php
$this->breadcrumbs = array(
    $this->getModule('category')->getCategory() => array(''),
    Yii::t('comment', 'Комментарии') => array('admin'),
    $model->id => array('view', 'id' => $model->id),
    Yii::t('comment', 'Редактирование'),
);

$this->menu = array(
    array('label' => Yii::t('comment', 'Список комментариев'), 'url' => array('index')),
    array('label' => Yii::t('comment', 'Добавить комментарий'), 'url' => array('create')),
    array('label' => Yii::t('comment', 'Просмотреть комментарий'), 'url' => array('view', 'id' => $model->id)),
    array('label' => Yii::t('comment', 'Управление комментариями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('comment', 'Редактирование комментария');?>
    #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>