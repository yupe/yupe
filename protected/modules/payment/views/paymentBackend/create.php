<?php
$this->breadcrumbs = [
    Yii::t('PaymentModule.payment', 'Payment methods') => ['/payment/paymentBackend/index'],
    Yii::t('PaymentModule.payment', 'Creating')
];

$this->pageTitle = Yii::t('PaymentModule.payment', 'Payment methods - creating');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('PaymentModule.payment', 'Manage payment methods'), 'url' => ['/payment/paymentBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('PaymentModule.payment', 'Create payment'), 'url' => ['/payment/paymentBackend/create']]
];
?>
<div class="page-header">
    <h1>
        <?=  Yii::t('PaymentModule.payment', 'Payment method'); ?>
        <small><?=  Yii::t('PaymentModule.payment', 'creating'); ?></small>
    </h1>
</div>

<?=  $this->renderPartial('_form', ['model' => $model]); ?>
