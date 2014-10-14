<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.store', 'Products') => array('/store/productBackend/index'),
    Yii::t('StoreModule.store', 'Creating'),
);

$this->pageTitle = Yii::t('StoreModule.store', 'Products - creating');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.store', 'Product admin'), 'url' => array('/store/productBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.store', 'Add a product'), 'url' => array('/store/productBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Products'); ?>
        <small><?php echo Yii::t('StoreModule.store', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
