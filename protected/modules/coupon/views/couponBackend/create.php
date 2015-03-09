<?php
$this->breadcrumbs = [
    Yii::t('CouponModule.coupon', 'Coupons') => ['/coupon/couponBackend/index'],
    Yii::t('CouponModule.coupon', 'Creating'),
];

$this->pageTitle = Yii::t('CouponModule.coupon', 'Coupons - creating');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('CouponModule.coupon', 'Manage coupons'), 'url' => ['/coupon/couponBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('CouponModule.coupon', 'Create coupon'), 'url' => ['/coupon/couponBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CouponModule.coupon', 'Coupons'); ?>
        <small><?php echo Yii::t('CouponModule.coupon', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
