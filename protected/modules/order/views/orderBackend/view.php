<?php
/* @var $model Order */
$this->breadcrumbs = [
    Yii::t('OrderModule.order', 'Orders') => ['/order/orderBackend/index'],
    Yii::t('OrderModule.order', 'Order #').$model->id,
];

$this->pageTitle = Yii::t('OrderModule.order', 'Orders - view');

$this->menu = [
    [
        'label' => Yii::t('OrderModule.order', 'Orders'),
        'items' => [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('OrderModule.order', 'Manage orders'),
                'url' => ['/order/orderBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('OrderModule.order', 'Create order'),
                'url' => ['/order/orderBackend/create'],
            ],
            ['label' => Yii::t('OrderModule.order', 'Order #').' «'.$model->id.'»'],
            [
                'icon' => 'fa fa-fw fa-pencil',
                'label' => Yii::t('OrderModule.order', 'Update order'),
                'url' => [
                    '/order/orderBackend/update',
                    'id' => $model->id,
                ],
            ],
            [
                'icon' => 'fa fa-fw fa-eye',
                'label' => Yii::t('OrderModule.order', 'View order'),
                'url' => [
                    '/order/orderBackend/view',
                    'id' => $model->id,
                ],
            ],
            [
                'icon' => 'fa fa-fw fa-trash-o',
                'label' => Yii::t('OrderModule.order', 'Delete order'),
                'url' => '#',
                'linkOptions' => [
                    'submit' => ['/order/orderBackend/delete', 'id' => $model->id],
                    'confirm' => Yii::t('OrderModule.order', 'Do you really want to remove this order?'),
                    'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
                    'csrf' => true,
                ],
            ],
        ],
    ],
    [
        'label' => Yii::t('OrderModule.order', 'Order statuses'),
        'items' => [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('OrderModule.order', 'Manage statuses'),
                'url' => ['/order/statusBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('OrderModule.order', 'Create status'),
                'url' => ['/order/statusBackend/create'],
            ],
        ],
    ],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('OrderModule.order', 'Viewing order'); ?>
        <small>&laquo;<?= Yii::t('OrderModule.order', '#'); ?><?= $model->id; ?>&raquo;</small>
    </h1>
</div>


<div class="row">
    <div class="col-sm-4">
        <?php $this->widget(
            'bootstrap.widgets.TbDetailView',
            [
                'data' => $model,
                'attributes' => [
                    'id',
                    'date',
                    [
                        'name' => 'status_id',
                        'value' => $model->status->getTitle(),
                    ],
                    [
                        'name' => 'total_price',
                        'value' => function ($model) {
                            return Yii::app()->numberFormatter->formatCurrency(
                                $model->getTotalPriceWithDelivery(),
                                'RUB'
                            );
                        },
                    ],
                    'discount',
                    'coupon_discount',
                    [
                        'name' => 'user_id',
                        'type' => 'raw',
                        'visible' => isset($model->client),
                        'value' => function ($model) {
                            return isset($model->client) ?
                                CHtml::link(
                                    $model->client->getFullName(),
                                    ['/order/clientBackend/view', 'id' => $model->user_id]
                                ) : '---';
                        },
                    ],
                    [
                        'name' => 'name',
                        'visible' => !isset($model->client),
                    ],
                    'phone',
                    'email',
                    'comment',
                    'note',
                    'modified',
                    'ip',
                    'url',
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-4">
        <?php $this->widget(
            'bootstrap.widgets.TbDetailView',
            [
                'data' => $model,
                'attributes' => [
                    [
                        'name' => 'delivery_id',
                        'value' => function ($model) {
                            return empty($model->delivery) ? '---' : $model->delivery->name;
                        },
                    ],
                    [
                        'name' => 'delivery_price',
                        'value' => function ($model) {
                            return Yii::app()->numberFormatter->formatCurrency($model->delivery_price, 'RUB');
                        },
                    ],
                    'separate_delivery:boolean',
                    'zipcode',
                    'country',
                    'city',
                    'street',
                    'house',
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-4">
        <?php $this->widget(
            'bootstrap.widgets.TbDetailView',
            [
                'data' => $model,
                'attributes' => [
                    [
                        'name' => 'payment_method_id',
                        'value' => function ($model) {
                            return empty($model->payment) ? '---' : $model->payment->name;
                        },
                    ],
                    'paid:boolean',
                    'payment_time',
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <?php $this->widget(
            'bootstrap.widgets.TbExtendedGridView',
            [
                'id' => 'products-grid',
                'type' => 'condensed',
                'dataProvider' => $products,
                'columns' => [
                    [
                        'type' => 'raw',
                        'value' => function ($data) {
                            return CHtml::image($data->product->getImageUrl(40, 40), "", ["class" => "img-thumbnail"]);
                        },
                    ],
                    [
                        'name' => 'product_name',
                    ],
                    'sku',
                    'quantity',
                    'price'
                ],
            ]
        ); ?>
    </div>
</div>
