<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Добавление'),
);

$this->menu=array(
	array('label' => Yii::t('dictionary', 'Список справочников'), 'url'=>array('index')),
	array('label' => Yii::t('dictionary', 'Управление справочниками'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('dictionary', 'Добавление справочника');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>