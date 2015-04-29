<?php
/**
 * @var $this ProductBackendController
 * @var $model Product
 */

$this->layout = 'product';

$this->breadcrumbs = [
    Yii::t('StoreModule.product', 'Products') => ['/store/productBackend/index'],
    $model->name,
];

$this->pageTitle = Yii::t('StoreModule.product', 'Products - view');

$this->menu = [

    ['label' => Yii::t('StoreModule.product', 'Product') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.product', 'Update product'),
        'url' => [
            '/store/productBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.product', 'View product'),
        'url' => [
            '/store/productBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.product', 'Delete product'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/store/productBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('StoreModule.product', 'Do you really want to remove product?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.product', 'Viewing product'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data' => $model,
        'attributes' => [
            'id',
            [
                'name' => 'type_id',
                'value' => function($model) {
                        return is_null($model->type) ? '---' : $model->type->name;
                    },
            ],
            [
                'name' => 'producer_id',
                'value' => function($model) {
                        return is_null($model->producer) ? '---' : $model->producer->name;
                    },
            ],
            'name',
            'price',
            'sku',
            [
                'name' => 'short_description',
                'type' => 'raw'
            ],
            [
                'name' => 'description',
                'type' => 'raw'
            ],
            'slug',
            [
                'name' => 'data',
                'type' => 'raw'
            ],
            [
                'name' => 'is_special',
                'value' => $model->getSpecial(),
            ],
            [
                'name' => 'status',
                'value' => $model->getStatusTitle(),
            ],
            [
                'name' => 'create_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_time, "short", "short"),
            ],
            [
                'name' => 'update_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_time, "short", "short"),
            ],
            'length',
            'width',
            'height',
            'weight',
            'quantity',
        ],
    ]
); ?>
