<?php
/**
 * @var Coupon $model
 */

$this->breadcrumbs = [
    Yii::t('CouponModule.coupon', 'Coupons') => ['/coupon/couponBackend/index'],
    $model->code => ['/coupon/couponBackend/view', 'id' => $model->id],
    Yii::t('CouponModule.coupon', 'Edition'),
];

$this->pageTitle = Yii::t('CouponModule.coupon', 'Coupons - edition');

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
    ['label' => Yii::t('CouponModule.coupon', 'Coupon') . ' «' . mb_substr($model->code, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('CouponModule.coupon', 'Update coupon'),
        'url' => [
            '/coupon/couponBackend/update',
            'id' => $model->id,
        ],
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('CouponModule.coupon', 'View coupon'),
        'url' => [
            '/coupon/couponBackend/view',
            'id' => $model->id,
        ],
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
        ],
    ],
];
?>
<div class="page-header">
    <h1>
        <?=  Yii::t('CouponModule.coupon', 'Updating coupon'); ?><br/>
        <small>&laquo;<?=  $model->code; ?>&raquo;</small>
    </h1>
</div>

<?=  $this->renderPartial('_form', ['model' => $model]); ?>
