<?php
/**
 * @var $this ProductBackendController
 * @var $model Product
 */

$this->layout = 'product';

$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Products') => ['/store/productBackend/index'],
    Yii::t('StoreModule.store', 'Creating'),
];

$this->pageTitle = Yii::t('StoreModule.store', 'Products - creating');
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.store', 'Products'); ?>
        <small><?= Yii::t('StoreModule.store', 'creating'); ?></small>
    </h1>
</div>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
