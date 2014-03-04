<?php
$this->breadcrumbs = array(
    Yii::t('ShopModule.product', 'Products') => array('/shop/productBackend/index'),
    Yii::t('ShopModule.product', 'Creating'),
);

$this->pageTitle = Yii::t('ShopModule.product', 'Products - creating');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.product', 'Product admin'), 'url' => array('/shop/productBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.product', 'Add a product'), 'url' => array('/shop/productBackend/create')),
);
?>
    <div class="page-header">
        <h1>
            <?php echo Yii::t('ShopModule.product', 'Products'); ?>
            <small><?php echo Yii::t('ShopModule.product', 'creating'); ?></small>
        </h1>
    </div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>