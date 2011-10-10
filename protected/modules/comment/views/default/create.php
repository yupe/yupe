<?php
$this->breadcrumbs = array(
    $this->getModule('category')->getCategory() => array(''),
    Yii::t('comment', 'Комментарии') => array('admin'),
    Yii::t('comment', 'Добавление'),
);

$this->menu = array(
    array('label' => Yii::t('comment', 'Список комментариев'), 'url' => array('index')),
    array('label' => Yii::t('comment', 'Управление комментариями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('comment', 'Добавление комментария');?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>