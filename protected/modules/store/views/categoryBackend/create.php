<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Categories') => ['/store/categoryBackend/index'],
    Yii::t('StoreModule.store', 'Creating'),
];

$this->pageTitle = Yii::t('StoreModule.store', 'Categories - create');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Manage categories'), 'url' => ['/store/categoryBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Create category'), 'url' => ['/store/categoryBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.store', 'Category'); ?>
        <small><?= Yii::t('StoreModule.store', 'creating'); ?></small>
    </h1>
</div>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
