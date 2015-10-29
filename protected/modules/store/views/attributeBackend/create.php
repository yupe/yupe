<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.attr', 'Attributes') => ['/store/attributeBackend/index'],
    Yii::t('StoreModule.store', 'Creating'),
];

$this->pageTitle = Yii::t('StoreModule.attr', 'Attributes - creating');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.attr', 'Manage attributes'), 'url' => ['/store/attributeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.attr', 'Create attribute'), 'url' => ['/store/attributeBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.attr', 'Attribute'); ?>
        <small><?= Yii::t('StoreModule.store', 'creating'); ?></small>
    </h1>
</div>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
