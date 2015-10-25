<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.attr', 'Attributes') => ['index'],
    $model->name,
];

$this->pageTitle = Yii::t('StoreModule.attr', 'Attributes - view');

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
        <?= Yii::t('StoreModule.attr', 'Viewing attribute'); ?><br/>
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
            'title',
            [
                'name' => 'type',
                'type' => 'text',
                'value' => $model->getTypeTitle($model->type),
            ],
            [
                'name' => 'required',
                'value' => $model->required ? Yii::t("StoreModule.store", 'Yes') : Yii::t("StoreModule.store", 'No'),
            ],
        ],
    ]
); ?>
