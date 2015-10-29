<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.category', 'Categories') => ['/store/categoryBackend/index'],
    Yii::t('StoreModule.store', 'Creating'),
];

$this->pageTitle = Yii::t('StoreModule.category', 'Categories - create');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.category', 'Manage categories'), 'url' => ['/store/categoryBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.category', 'Create category'), 'url' => ['/store/categoryBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.category', 'Category'); ?>
        <small><?= Yii::t('StoreModule.store', 'creating'); ?></small>
    </h1>
</div>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
