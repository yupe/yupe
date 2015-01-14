<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Атрибуты') => ['index'],
    $model->name,
];

$this->pageTitle = Yii::t('StoreModule.store', 'Атрибуты - просмотр');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Управление'), 'url' => ['/store/attributeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Добавить'), 'url' => ['/store/attributeBackend/create']],
    ['label' => Yii::t('StoreModule.store', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.store', 'Редактировать'),
        'url' => [
            '/store/attributeBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.store', 'Просмотр'),
        'url' => [
            '/store/attributeBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.store', 'Удалить'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/store/attributeBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('StoreModule.store', 'Do you really want to remove attribute?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Просмотр атрибута'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
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
                'value' => $model->required ? Yii::t("StoreModule.store", 'Да') : Yii::t("StoreModule.store", 'Нет'),
            ],
        ],
    ]
); ?>
