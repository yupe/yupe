<?php
    $this->breadcrumbs = array(
        Yii::t('ShopModule.delivery', 'Способы доставки') => array('/shop/deliveryBackend/index'),
        Yii::t('ShopModule.delivery', 'Добавить'),
    );

    $this->pageTitle = Yii::t('ShopModule.delivery', 'Способы доставки - добавить');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.delivery', 'Управление способами доставки'), 'url' => array('/shop/deliveryBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.delivery', 'Добавить способ доставки'), 'url' => array('/shop/deliveryBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.delivery', 'Способы доставки'); ?>
        <small><?php echo Yii::t('ShopModule.delivery', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>