<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Значения справочников') => array('admin'),
    Yii::t('dictionary', 'Добавление'),
);

$this->menu=array(
	array('icon' => 'list-alt','label' => Yii::t('dictionary', 'Список значений'), 'url'=>array('/dictionary/dictionaryData/admin/')),	
);
?>

<h1><?php echo Yii::t('dictionary', 'Добавление значения в справочник');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>