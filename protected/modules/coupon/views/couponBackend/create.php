<?php
/**
 * @var Coupon $model
 */

$this->breadcrumbs = [
    Yii::t('CouponModule.coupon', 'Coupons') => ['/coupon/couponBackend/index'],
    Yii::t('CouponModule.coupon', 'Creating'),
];

$this->pageTitle = Yii::t('CouponModule.coupon', 'Coupons - creating');

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
        <small><?=  Yii::t('CouponModule.coupon', 'creating'); ?></small>
    </h1>
</div>

<?=  $this->renderPartial('_form', ['model' => $model]); ?>
