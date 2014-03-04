<?php
$this->breadcrumbs = array(
    Yii::t('CatalogModule.catalog', 'Products') => array('/catalog/catalogBackend/index'),
    Yii::t('CatalogModule.catalog', 'Import'),
);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                     => 'import-form',
    'htmlOptions'            => array('class' => 'well', 'enctype'=>'multipart/form-data'),
)); ?>
<?php echo CHtml::fileField('file', null, array('class' => 'alert alert-info'));?>

    * Прайс-лист в формате CSV (Из Excel - сохранить как CSV)
    <br/>
<?php echo CHtml::submitButton(Yii::t('CatalogModule.catalog', 'Import'), array('class' => 'btn btn-primary'));?>
<?php $this->endWidget(); ?>