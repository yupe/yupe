<?php
/**
 * @var Coupon $model
 */

$this->breadcrumbs = [
    Yii::t('CouponModule.coupon', 'Coupons') => ['/coupon/couponBackend/index'],
    Yii::t('CouponModule.coupon', 'Manage'),
];

$this->pageTitle = Yii::t('CouponModule.coupon', 'Coupons - manage');

$this->menu = [
    [
        'icon' => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('CouponModule.coupon', 'Manage coupons'),
        'url' => ['/coupon/couponBackend/index'],
    ],
    [
        'icon' => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('CouponModule.coupon', 'Create coupon'),
        'url' => ['/coupon/couponBackend/create'],
    ],
];
?>
<div class="page-header">
    <h1>
        <?=  Yii::t('CouponModule.coupon', 'Coupons'); ?>
        <small><?=  Yii::t('CouponModule.coupon', 'manage'); ?></small>
    </h1>
</div>


<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'coupon-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => [
            [
                'name' => 'name',
                'type' => 'raw',
                'value' => function (Coupon $data) {
                    return CHtml::link($data->name, ['/coupon/couponBackend/update', 'id' => $data->id]);
                },
            ],
            'code',
            'start_time',
            'end_time',
            [
                'class' => 'yupe\widgets\EditableStatusColumn',
                'name' => 'status',
                'url' => $this->createUrl('/coupon/couponBackend/inline'),
                'source' => CouponStatus::all(),
                'options' => CouponStatus::colors(),
            ],
            [
                'header' => Yii::t('CouponModule.coupon', 'Orders'),
                'value' => function (Coupon $data) {
                    return CHtml::link(
                        $data->ordersCount,
                        ['/order/orderBackend/index', 'Order[couponId]' => $data->id],
                        ['class' => 'badge']
                    );
                },
                'type' => 'raw',
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
