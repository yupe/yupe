<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Product types') => ['/store/typeBackend/index'],
    Yii::t('StoreModule.store', 'Creating'),
];

$this->pageTitle = Yii::t('StoreModule.store', 'Product types - create');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Type manage'), 'url' => ['/store/typeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Create type'), 'url' => ['/store/typeBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.store', 'Product type'); ?>
        <small><?= Yii::t('StoreModule.store', 'creating'); ?></small>
    </h1>
</div>

<?= $this->renderPartial('_form', ['model' => $model, 'availableAttributes' => $availableAttributes]); ?>
