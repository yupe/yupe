<?php
$this->breadcrumbs = array(
    $this->getModule('comment')->getCategory() => array(''),
    Yii::t('comment', 'Комментарии') => array('/comment/default/index'),
    $model->id => array('view', 'id' => $model->id),
    Yii::t('comment', 'Редактирование'),
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('comment', 'Список комментариев'), 'url' => array('/comment/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('comment', 'Добавить комментарий'), 'url' => array('/comment/default/create')),
    array('icon' => 'eye-open', 'label' => Yii::t('comment', 'Просмотреть комментарий'), 'url' => array('/comment/default/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('comment', 'Редактирование комментария'); ?> #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>