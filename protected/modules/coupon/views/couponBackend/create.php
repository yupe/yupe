<?php
$this->breadcrumbs = [
    Yii::t('CouponModule.coupon', 'Купоны') => ['/coupon/couponBackend/index'],
    Yii::t('CouponModule.coupon', 'Добавить'),
];

$this->pageTitle = Yii::t('CouponModule.coupon', 'Купоны - добавить');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('CouponModule.coupon', 'Управление купонами'), 'url' => ['/coupon/couponBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('CouponModule.coupon', 'Добавить купон'), 'url' => ['/coupon/couponBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CouponModule.coupon', 'Купоны'); ?>
        <small><?php echo Yii::t('CouponModule.coupon', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
