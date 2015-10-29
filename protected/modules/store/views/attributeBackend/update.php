<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.attr', 'Attributes') => ['/store/attributeBackend/index'],
    $model->name => ['/store/attributeBackend/view', 'id' => $model->id],
    Yii::t('StoreModule.store', 'Edition'),
];

$this->pageTitle = Yii::t('StoreModule.attr', 'Attributes - editing');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.attr', 'Manage attributes'), 'url' => ['/store/attributeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.attr', 'Create attribute'), 'url' => ['/store/attributeBackend/create']],
    ['label' => Yii::t('StoreModule.attr', 'Attribute') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.attr', 'Update attribute'),
        'url' => [
            '/store/attributeBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.attr', 'View attribute'),
        'url' => [
            '/store/attributeBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.attr', 'Delete attribute'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/store/attributeBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('StoreModule.attr', 'Do you really want to remove attribute?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.attr', 'Updating attribute'); ?><br/>
        <small>&laquo;<?= $model->name; ?>&raquo;</small>
    </h1>
</div>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
