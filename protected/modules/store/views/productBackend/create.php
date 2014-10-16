<?php
/**
 * @var $this ProductBackendController
 * @var $model Product
 */

$this->layout = 'product';

$this->breadcrumbs = array(
    Yii::t('StoreModule.store', 'Products') => array('/store/productBackend/index'),
    Yii::t('StoreModule.store', 'Creating'),
);

$this->pageTitle = Yii::t('StoreModule.store', 'Products - creating');
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Products'); ?>
        <small><?php echo Yii::t('StoreModule.store', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
