<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.producer', 'Producers') => ['/store/producerBackend/index'],
    Yii::t('StoreModule.store', 'Creating'),
];

$this->pageTitle = Yii::t('StoreModule.producer', 'Producers - create');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.producer', 'Manage producers'), 'url' => ['/store/producerBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.producer', 'Create producer'), 'url' => ['/store/producerBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.producer', 'Producer'); ?>
        <small><?= Yii::t('StoreModule.store', 'creating'); ?></small>
    </h1>
</div>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
