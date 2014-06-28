<?php
$this->breadcrumbs = array(
    Yii::t('ShopModule.coupon', 'Купоны') => array('/shop/couponBackend/index'),
    Yii::t('ShopModule.coupon', 'Добавить'),
);

$this->pageTitle = Yii::t('ShopModule.coupon', 'Купоны - добавить');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.coupon', 'Управление купонами'), 'url' => array('/shop/couponBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.coupon', 'Добавить купон'), 'url' => array('/shop/couponBackend/create')),
);
?>
    <div class="page-header">
        <h1>
            <?php echo Yii::t('ShopModule.coupon', 'Купоны'); ?>
            <small><?php echo Yii::t('ShopModule.coupon', 'добавить'); ?></small>
        </h1>
    </div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>