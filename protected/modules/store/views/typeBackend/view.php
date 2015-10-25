<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.type', 'Product types') => ['index'],
    $model->name,
];

$this->pageTitle = Yii::t('StoreModule.type', 'Product types - view');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.type', 'Type manage'), 'url' => ['/store/typeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.type', 'Create type'), 'url' => ['/store/typeBackend/create']],
    ['label' => Yii::t('StoreModule.type', 'Product type') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.type', 'Update type'),
        'url' => [
            '/store/typeBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.type', 'View type'),
        'url' => [
            '/store/typeBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.type', 'Delete type'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/store/typeBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('StoreModule.attribute', 'Do you really want to remove attribute?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.type', 'Viewing type'); ?><br/>
        <small>&laquo;<?= $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]
); ?>
