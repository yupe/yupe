<?php
$this->breadcrumbs = array(
    $this->getModule('news')->getCategory() => array(''),
    Yii::t('news', 'Новости') => array('admin'),
    Yii::t('news', 'Добавление новости'),
);

$this->menu = array(
    array('label' => Yii::t('news', 'Список новостей'), 'url' => array('index')),
    array('label' => Yii::t('news', 'Управление новостями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('news', 'Добавление новости');?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>