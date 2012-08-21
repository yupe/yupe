<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Данные справочников') => array('admin'),
    Yii::t('dictionary', 'Редактирование'),
);

$this->menu=array(
	array( 'label' => Yii::t('dictionary', 'Список значений'), 'url'=>array('index')),
	array( 'label' => Yii::t('dictionary', 'Добавить значение'), 'url'=>array('create')),
	array( 'label' => Yii::t('dictionary', 'Просмотр значения'), 'url'=>array('view', 'id'=>$model->id)),
	array( 'label' => Yii::t('dictionary', 'Управление значениями'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('dictionary', 'Редактирование значения');?> #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>