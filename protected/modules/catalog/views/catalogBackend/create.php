<?php
$this->breadcrumbs = [
    Yii::t('CatalogModule.catalog', 'Products') => ['/catalog/catalogBackend/index'],
    Yii::t('CatalogModule.catalog', 'Creating'),
];

$this->pageTitle = Yii::t('CatalogModule.catalog', 'Products - creating');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('CatalogModule.catalog', 'Product admin'),
        'url'   => ['/catalog/catalogBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('CatalogModule.catalog', 'Add a product'),
        'url'   => ['/catalog/catalogBackend/create']
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CatalogModule.catalog', 'Products'); ?>
        <small><?php echo Yii::t('CatalogModule.catalog', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
