<?php
    $this->breadcrumbs = array(        
        Yii::t('ShopModule.type', 'Типы товаров') => array('/shop/typeBackend/index'),
        Yii::t('ShopModule.type', 'Добавить'),
    );

    $this->pageTitle = Yii::t('ShopModule.type', 'Типы товаров - добавить');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.type', 'Управление'), 'url' => array('/shop/typeBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.type', 'Добавить'), 'url' => array('/shop/typeBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.type', 'Тип товара'); ?>
        <small><?php echo Yii::t('ShopModule.type', 'добавить'); ?></small>
    </h1>
</div>

<?php echo  $this->renderPartial('_form', array('model' => $model, 'languages' => $languages, 'availableAttributes' => $availableAttributes)); ?>