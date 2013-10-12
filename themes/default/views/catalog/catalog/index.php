<?php
$this->pageTitle = Yii::t('CatalogModule.catalog', 'Products');
$this->breadcrumbs = array(Yii::t('CatalogModule.catalog', 'Products'));
?>

<h1><?php echo Yii::t('CatalogModule.catalog', 'Products'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
      'dataProvider' => $dataProvider,
      'itemView' => '_view',
)); ?>
