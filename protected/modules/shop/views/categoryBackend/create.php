<?php
    $this->breadcrumbs = array(        
        Yii::t('ShopModule.category', 'Categories') => array('/shop/categoryBackend/index'),
        Yii::t('ShopModule.category', 'Create'),
    );

    $this->pageTitle = Yii::t('ShopModule.category', 'Categories - create');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.category', 'Category manage'), 'url' => array('/shop/categoryBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.category', 'Create category'), 'url' => array('/shop/categoryBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.category', 'Category'); ?>
        <small><?php echo Yii::t('ShopModule.category', 'create'); ?></small>
    </h1>
</div>

<?php echo  $this->renderPartial('_form', array('model' => $model, 'languages' => $languages)); ?>