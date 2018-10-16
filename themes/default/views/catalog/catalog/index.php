<?php
$this->pageTitle = Yii::t('CatalogModule.catalog', 'Products');
$this->breadcrumbs = [Yii::t('CatalogModule.catalog', 'Products')];
?>

<h1><?php echo Yii::t('CatalogModule.catalog', 'Products'); ?></h1>

<?php $this->widget(
    'zii.widgets.CListView',
    [
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
    ]
); ?>
