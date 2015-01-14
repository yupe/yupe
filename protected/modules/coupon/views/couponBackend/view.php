<?php
/* @var $model Coupon */
$this->breadcrumbs = [
    Yii::t('CouponModule.coupon', 'Купоны') => ['/coupon/couponBackend/index'],
    $model->code,
];

$this->pageTitle = Yii::t('CouponModule.coupon', 'Купоны - просмотр');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('CouponModule.coupon', 'Управление купонами'), 'url' => ['/coupon/couponBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('CouponModule.coupon', 'Добавить купон'), 'url' => ['/coupon/couponBackend/create']],
    ['label' => Yii::t('CouponModule.coupon', 'Купон') . ' «' . mb_substr($model->code, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('CouponModule.coupon', 'Редактирование купона'),
        'url' => [
            '/coupon/couponBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('CouponModule.coupon', 'Просмотреть купон'),
        'url' => [
            '/coupon/couponBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('CouponModule.coupon', 'Удалить купон'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/coupon/couponBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('CouponModule.coupon', 'Вы уверены, что хотите удалить купон?'),
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CouponModule.coupon', 'Просмотр') . ' ' . Yii::t('CouponModule.coupon', 'купона'); ?><br/>
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
            'date_start',
            'date_end',
            'quantity',
            'quantity_per_user',
            [
                'name' => 'status',
                'value' => $model->statusTitle,
            ],

        ],
    ]
); ?>
