<?php
$this->breadcrumbs = array(
    Yii::t('ShopModule.product', 'Products') => array('/shop/productBackend/index'),
    $model->name => array('/shop/productBackend/view', 'id' => $model->id),
    Yii::t('ShopModule.product', 'Edition'),
);

$this->pageTitle = Yii::t('ShopModule.product', 'Products - edition');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.product', 'Products administration'), 'url' => array('/shop/productBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.product', 'Add a product'), 'url' => array('/shop/productBackend/create')),
    array('label' => Yii::t('ShopModule.product', 'Product') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array('icon' => 'pencil', 'label' => Yii::t('ShopModule.product', 'Update product'), 'url' => array(
        '/shop/productBackend/update',
        'id' => $model->id
    )),
    array('icon' => 'eye-open', 'label' => Yii::t('ShopModule.product', 'Show product'), 'url' => array(
        '/shop/productBackend/view',
        'id' => $model->id
    )),
    array('icon' => 'trash', 'label' => Yii::t('ShopModule.product', 'Remove product'), 'url' => '#', 'linkOptions' => array(
        'submit' => array('/shop/productBackend/delete', 'id' => $model->id),
        'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
        'confirm' => Yii::t('ShopModule.product', 'Do you really want to remove product?'),
        'csrf' => true,
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.product', 'Update product'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
