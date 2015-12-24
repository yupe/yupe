<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Producers') => ['/store/producerBackend/index'],
    Yii::t('StoreModule.store', 'Creating'),
];

$this->pageTitle = Yii::t('StoreModule.store', 'Producers - create');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Manage producers'), 'url' => ['/store/producerBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Create producer'), 'url' => ['/store/producerBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.store', 'Producer'); ?>
        <small><?= Yii::t('StoreModule.store', 'creating'); ?></small>
    </h1>
</div>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
