<?php
$this->breadcrumbs = [
    Yii::t('CatalogModule.catalog', 'Products') => ['/catalog/catalogBackend/index'],
    $model->name,
];

$this->pageTitle = Yii::t('CatalogModule.catalog', 'Products - view');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('CatalogModule.catalog', 'Products administration'),
        'url'   => ['/catalog/catalogBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('CatalogModule.catalog', 'Add a product'),
        'url'   => ['/catalog/catalogBackend/create']
    ],
    ['label' => Yii::t('CatalogModule.catalog', 'Product') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('CatalogModule.catalog', 'Update product'),
        'url'   => [
            '/catalog/catalogBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('CatalogModule.catalog', 'Show product'),
        'url'   => [
            '/catalog/catalogBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('CatalogModule.catalog', 'Delete product'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/catalog/catalogBackend/delete', 'id' => $model->id],
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('CatalogModule.catalog', 'Do you really want to remove product?'),
            'csrf'    => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CatalogModule.catalog', 'Product show'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'id',
            [
                'name'  => 'category_id',
                'value' => $model->category->name,
            ],
            'name',
            'price',
            'article',
            'image',
            [
                'name' => 'short_description',
                'type' => 'raw'
            ],
            [
                'name' => 'description',
                'type' => 'raw'
            ],
            'alias',
            [
                'name' => 'data',
                'type' => 'raw'
            ],
            [
                'name'  => 'is_special',
                'value' => $model->getSpecial(),
            ],
            [
                'name'  => 'status',
                'value' => $model->getStatus(),
            ],
            [
                'name'  => 'user_id',
                'value' => $model->user->getFullName(),
            ],
            [
                'name'  => 'change_user_id',
                'value' => $model->changeUser->getFullName(),
            ],
            [
                'name'  => 'create_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_time, "short", "short"),
            ],
            [
                'name'  => 'update_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_time, "short", "short"),
            ],
        ],
    ]
); ?>
