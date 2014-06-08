<?php
    $this->breadcrumbs = array(
        Yii::t('ShopModule.payment', 'Способы оплаты') => array('/shop/paymentBackend/index'),
        Yii::t('ShopModule.payment', 'Добавить'),
    );

    $this->pageTitle = Yii::t('ShopModule.payment', 'Способы оплаты - добавить');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.payment', 'Управление способами оплаты'), 'url' => array('/shop/paymentBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.payment', 'Добавить способ оплаты'), 'url' => array('/shop/paymentBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.payment', 'Способы оплаты'); ?>
        <small><?php echo Yii::t('ShopModule.payment', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>