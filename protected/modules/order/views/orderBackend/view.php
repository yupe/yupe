<?php
/* @var $model Order */
$this->breadcrumbs = [
    Yii::t('OrderModule.order', 'Orders') => ['/order/orderBackend/index'],
    $model->id,
];

$this->pageTitle = Yii::t('OrderModule.order', 'Orders - view');

$this->menu = [
    [
        'label' => Yii::t('OrderModule.order', 'Orders'),
        'items' => [
            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('OrderModule.order', 'Manage orders'), 'url' => ['/order/orderBackend/index']],
            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('OrderModule.order', 'Create order'), 'url' => ['/order/orderBackend/create']],
            ['label' => Yii::t('OrderModule.order', 'Order #') . ' «' . $model->id . '»'],
            [
                'icon' => 'fa fa-fw fa-pencil',
                'label' => Yii::t('OrderModule.order', 'Update order'),
                'url' => [
                    '/order/orderBackend/update',
                    'id' => $model->id
                ]
            ],
            [
                'icon' => 'fa fa-fw fa-eye',
                'label' => Yii::t('OrderModule.order', 'View order'),
                'url' => [
                    '/order/orderBackend/view',
                    'id' => $model->id
                ]
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
                ]
            ],
        ]
    ],
    [
        'label' => Yii::t('OrderModule.order', 'Order statuses'),
        'items' => [
            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('OrderModule.order', 'Manage statuses'), 'url' => ['/order/statusBackend/index']],
            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('OrderModule.order', 'Create status'), 'url' => ['/order/statusBackend/create']],
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('OrderModule.order', 'Viewing order'); ?>
        <small>&laquo;<?php echo Yii::t('OrderModule.order', '#'); ?><?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data' => $model,
        'attributes' => [
            'id',
            [
                'name' => 'delivery_id',
                'value' => function($model){
                    return empty($model->delivery) ? '---' : $model->delivery->name;
                }
            ],
            'delivery_price',
            [
                'name' => 'payment_method_id',
                'value' => function($model){
                    return empty($model->payment) ? '---' : $model->payment->name;
                }
            ],
            'paid',
            'payment_time',
            'total_price',
            'discount',
            'coupon_discount',
            'separate_delivery',
            [
                'name' => 'status_id',
                'value' => $model->status->getTitle(),
            ],
            'date',
            [
                'name' => 'user_id',
                'type' => 'raw',
                'value' => function($model) {
                        return $model->user ?
                            CHtml::link($model->user->nick_name, ['/user/userBackend/view', 'id' => $model->user_id]) : '---';
                    },
            ],
            'name',
            'address',
            'phone',
            'email',
            'comment',
            'ip',
            'url',
            'note',
            'modified'
        ],
    ]
); ?>
