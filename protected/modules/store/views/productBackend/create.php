<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.product', 'Products') => array('/store/productBackend/index'),
    Yii::t('StoreModule.product', 'Creating'),
);

$this->pageTitle = Yii::t('StoreModule.product', 'Products - creating');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.product', 'Product admin'), 'url' => array('/store/productBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.product', 'Add a product'), 'url' => array('/store/productBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.product', 'Products'); ?>
        <small><?php echo Yii::t('StoreModule.product', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
