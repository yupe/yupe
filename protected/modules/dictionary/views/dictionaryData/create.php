<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Данные справочников') => array('admin'),
    Yii::t('dictionary', 'Добавление'),
);

$this->menu=array(
	array('label' => Yii::t('dictionary', 'Список значений'), 'url'=>array('index')),
	array('label' => Yii::t('dictionary', 'Управление значениями'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('dictionary', 'Добавление значения в справочник');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>