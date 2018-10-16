<?php
/* @var $model Export */

$this->breadcrumbs = [
    Yii::t('YmlModule.default', 'Products export') => ['/yml/exportBackend/index'],
    Yii::t('YmlModule.default', 'Creating'),
];

$this->pageTitle = Yii::t('YmlModule.default', 'Products export - creating');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('YmlModule.default', 'Manage export lists'), 'url' => ['/yml/exportBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('YmlModule.default', 'Create export list'), 'url' => ['/yml/exportBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('YmlModule.default', 'Products export'); ?>
        <small><?= Yii::t('YmlModule.default', 'creating'); ?></small>
    </h1>
</div>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
