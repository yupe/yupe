<?php
$this->breadcrumbs = array(
    Yii::t('CouponModule.coupon', 'Купоны') => array('/coupon/couponBackend/index'),
    Yii::t('CouponModule.coupon', 'Добавить'),
);

$this->pageTitle = Yii::t('CouponModule.coupon', 'Купоны - добавить');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('CouponModule.coupon', 'Управление купонами'), 'url' => array('/coupon/couponBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('CouponModule.coupon', 'Добавить купон'), 'url' => array('/coupon/couponBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CouponModule.coupon', 'Купоны'); ?>
        <small><?php echo Yii::t('CouponModule.coupon', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
