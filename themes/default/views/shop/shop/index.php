<?php
/**
 * @var $dataProvider CActiveDataProvider
 */
$this->pageTitle = Yii::t('CatalogModule.catalog', 'Products');
$this->breadcrumbs = array(Yii::t('CatalogModule.catalog', 'Products'));
$assets = Yii::app()->assetManager->getPublishedUrl(
    Yii::app()->theme->basePath . "/web/"
);
?>

<h1><?php echo Yii::t('CatalogModule.catalog', 'Products'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'viewData' => array( 'assets' => $assets ),
    'itemView' => '_view',
    'itemsCssClass' => 'row items'
)); ?>

