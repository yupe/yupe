<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Добавление'),
);

$this->menu=array(
	array('icon' => 'plus-sign','label' => Yii::t('dictionary', 'Добавление справочника'), 'url'=>array('/dictionary/default/create')),
	array('icon' => 'list-alt','label' => Yii::t('dictionary', 'Управление справочниками'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('dictionary', 'Добавление справочника');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>