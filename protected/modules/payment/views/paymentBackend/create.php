<?php
$this->breadcrumbs = array(
    Yii::t('PaymentModule.payment', 'Способы оплаты') => array('/payment/paymentBackend/index'),
    Yii::t('PaymentModule.payment', 'Добавить'),
);

$this->pageTitle = Yii::t('PaymentModule.payment', 'Способы оплаты - добавить');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('PaymentModule.payment', 'Управление способами оплаты'), 'url' => array('/payment/paymentBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('PaymentModule.payment', 'Добавить способ оплаты'), 'url' => array('/payment/paymentBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PaymentModule.payment', 'Способы оплаты'); ?>
        <small><?php echo Yii::t('PaymentModule.payment', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
