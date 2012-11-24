<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('/dictionary/default/index'),
    Yii::t('dictionary', 'Значения справочников') => array('/dictionary/dictionaryData/index'),
    Yii::t('dictionary', 'Редактирование'),
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('dictionary', 'Список значений'), 'url' => array('/dictionary/dictionaryData/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('dictionary', 'Добавить значение'), 'url' => array('/dictionary/dictionaryData/create')),
    array('icon' => 'eye-open', 'label' => Yii::t('dictionary', 'Просмотр значения'), 'url' => array('/dictionary/dictionaryData/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('dictionary', 'Редактирование значения'); ?> "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>