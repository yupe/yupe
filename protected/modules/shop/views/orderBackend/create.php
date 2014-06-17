<?php
    $this->breadcrumbs = array(
        Yii::t('ShopModule.order', 'Заказы') => array('/shop/orderBackend/index'),
        Yii::t('ShopModule.order', 'Добавить'),
    );

    $this->pageTitle = Yii::t('ShopModule.order', 'Заказы - добавить');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.order', 'Управление заказами'), 'url' => array('/shop/orderBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.order', 'Добавить заказ'), 'url' => array('/shop/orderBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.order', 'Заказы'); ?>
        <small><?php echo Yii::t('ShopModule.order', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>