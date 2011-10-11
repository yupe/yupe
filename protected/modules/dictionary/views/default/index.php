<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Группы справочников') => array('admin'),
    Yii::t('dictionary', 'Список'),
);

$this->menu=array(
	array('label' => Yii::t('dictionary', 'Добавить группу'), 'url'=>array('create')),
	array('label' => Yii::t('dictionary', 'Управление группами'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('dictionary', 'Список групп справочников');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
