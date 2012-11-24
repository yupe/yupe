<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('/dictionary/default/index'),
    Yii::t('dictionary', 'Редактирование'),
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('dictionary', 'Список справочников'), 'url' => array('/dictionary/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('dictionary', 'Добавить справочник'), 'url' => array('/dictionary/default/create')),
    array('icon' => 'eye-open', 'label' => Yii::t('dictionary', 'Просмотр справочника'), 'url' => array('/dictionary/default/view', 'id' => $model->id)),
    array('icon' => 'list-alt', 'label' => Yii::t('dictionary', 'Данные справочника'), 'url' => array("/dictionary/dictionaryData/index?group_id={$model->id}")),
);
?>

<h1><?php echo Yii::t('dictionary', 'Редактирование справочника'); ?> "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>