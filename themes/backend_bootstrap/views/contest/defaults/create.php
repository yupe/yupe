<?php
$this->breadcrumbs = array(
    $this->getModule('contest')->getCategory() => array(''),
    Yii::t('contest', 'Конкурсы изображений') => array('admin'),
    Yii::t('contest', 'Добавление'),
);

$this->menu = array(
    array('label' => Yii::t('contest', 'Список конкурсов'), 'url' => array('index')),
    array('label' => Yii::t('contest', 'Управление конкурсами'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('contest', 'Добавление конкурса');?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>