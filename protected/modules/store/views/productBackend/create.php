<?php
/**
 * @var $this ProductBackendController
 * @var $model Product
 */

$this->layout = 'product';

$this->breadcrumbs = [
    Yii::t('StoreModule.product', 'Products') => ['/store/productBackend/index'],
    Yii::t('StoreModule.store', 'Creating'),
];

$this->pageTitle = Yii::t('StoreModule.product', 'Products - creating');
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.product', 'Products'); ?>
        <small><?php echo Yii::t('StoreModule.store', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
