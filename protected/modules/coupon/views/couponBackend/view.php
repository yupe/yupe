<?php
/* @var $model Coupon */
$this->breadcrumbs = [
    Yii::t('CouponModule.coupon', 'Coupons') => ['/coupon/couponBackend/index'],
    $model->code,
];

$this->pageTitle = Yii::t('CouponModule.coupon', 'Coupons - view');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('CouponModule.coupon', 'Manage coupons'), 'url' => ['/coupon/couponBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('CouponModule.coupon', 'Create coupon'), 'url' => ['/coupon/couponBackend/create']],
    ['label' => Yii::t('CouponModule.coupon', 'Coupon') . ' «' . mb_substr($model->code, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('CouponModule.coupon', 'Update coupon'),
        'url' => [
            '/coupon/couponBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('CouponModule.coupon', 'View coupon'),
        'url' => [
            '/coupon/couponBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('CouponModule.coupon', 'Delete coupon'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/coupon/couponBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('CouponModule.coupon', 'Do you really want to remove this coupon?'),
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CouponModule.coupon', 'Viewing coupon'); ?><br/>
        <small>&laquo;<?php echo $model->code; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data' => $model,
        'attributes' => [
            'id',
            'name',
            'code',
            [
                'name' => 'type',
                'value' => $model->getTypeTitle(),
            ],
            'value',
            'min_order_price',
            'registered_user:boolean',
            'free_shipping:boolean',
            'start_time',
            'end_time',
            'quantity',
            'quantity_per_user',
            [
                'name' => 'status',
                'value' => $model->statusTitle,
            ],

        ],
    ]
); ?>
