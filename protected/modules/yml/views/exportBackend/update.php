<?php
/* @var $model Export */

$this->breadcrumbs = [
    Yii::t('YmlModule.default', 'Products export') => ['/yml/exportBackend/index'],
    Yii::t('YmlModule.default', 'Edition'),
];

$this->pageTitle = Yii::t('YmlModule.default', 'Products export - edition');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('YmlModule.default', 'Manage export lists'), 'url' => ['/yml/exportBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('YmlModule.default', 'Create export list'), 'url' => ['/yml/exportBackend/create']],
    ['label' => Yii::t('YmlModule.default', 'Export list') . ' «' . mb_substr(CHtml::encode($model->name), 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('YmlModule.default', 'Update export list'),
        'url' => [
            '/yml/exportBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('YmlModule.default', 'Delete export list'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/yml/exportBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('YmlModule.default', 'Do you really want to remove this export list?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('YmlModule.default', 'Updating export list'); ?><br/>
        <small>&laquo;<?= CHtml::encode($model->name); ?>&raquo;</small>
    </h1>
</div>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
