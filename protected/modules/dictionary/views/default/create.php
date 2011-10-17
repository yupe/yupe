<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Группы справочников') => array('admin'),
    Yii::t('dictionary', 'Добавление'),
);

$this->menu=array(
	array('label' => Yii::t('dictionary', 'Список групп'), 'url'=>array('index')),
	array('label' => Yii::t('dictionary', 'Управление группами'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('dictionary', 'Добавление группы справочников');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>