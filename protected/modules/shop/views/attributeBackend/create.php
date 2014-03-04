<?php
    $this->breadcrumbs = array(        
        Yii::t('ShopModule.attribute', 'Атрибуты') => array('/shop/attributeBackend/index'),
        Yii::t('ShopModule.attribute', 'Добавить'),
    );

    $this->pageTitle = Yii::t('ShopModule.attribute', 'Атрибуты - добавить');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.attribute', 'Управление'), 'url' => array('/shop/attributeBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.attribute', 'Добавить'), 'url' => array('/shop/attributeBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.attribute', 'Атрибут'); ?>
        <small><?php echo Yii::t('ShopModule.attribute', 'добавить'); ?></small>
    </h1>
</div>

<?php echo  $this->renderPartial('_form', array('model' => $model, 'languages' => $languages)); ?>