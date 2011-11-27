<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Группы справочников') => array('admin'),
    Yii::t('dictionary', 'Редактирование'),
);


$this->menu=array(
	array('label' => Yii::t('dictionary', 'Список групп'), 'url'=>array('index')),
	array('label' => Yii::t('dictionary', 'Добавить группу'), 'url'=>array('create')),
	array('label' => Yii::t('dictionary', 'Просмотр группы'), 'url'=>array('view', 'id'=>$model->id)),
	array('label' => Yii::t('dictionary', 'Управление группами'), 'url'=>array('admin')),
	array('label' => Yii::t('dictionary', 'Данные этой группы'), 'url'=>array("/dictionary/dictionaryData/admin?group_id={$model->id}")),
);
?>

<h1><?php echo Yii::t('dictionary', 'Редактирование группы справочников');?> "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>