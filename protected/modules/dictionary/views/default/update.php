<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Редактирование'),
);


$this->menu=array(
	array('label' => Yii::t('dictionary', 'Список справочников'), 'url'=>array('index')),
	array('label' => Yii::t('dictionary', 'Добавить справочник'), 'url'=>array('create')),
	array('label' => Yii::t('dictionary', 'Просмотр справочника'), 'url'=>array('view', 'id'=>$model->id)),
	array('label' => Yii::t('dictionary', 'Управление справочниками'), 'url'=>array('admin')),
	array('label' => Yii::t('dictionary', 'Данные справочника'), 'url'=>array("/dictionary/dictionaryData/admin?group_id={$model->id}")),
);
?>

<h1><?php echo Yii::t('dictionary', 'Редактирование справочника');?> "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>