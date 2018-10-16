<?php
$this->breadcrumbs = [
    Yii::t('DeliveryModule.delivery', 'Delivery methods') => ['/delivery/deliveryBackend/index'],
    Yii::t('DeliveryModule.delivery', 'Creating'),
];

$this->pageTitle = Yii::t('DeliveryModule.delivery', 'Delivery methods - creating');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('DeliveryModule.delivery', 'Manage delivery methods'), 'url' => ['/delivery/deliveryBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('DeliveryModule.delivery', 'Create delivery'), 'url' => ['/delivery/deliveryBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('DeliveryModule.delivery', 'Delivery methods'); ?>
        <small><?= Yii::t('DeliveryModule.delivery', 'creating'); ?></small>
    </h1>
</div>

<?= $this->renderPartial('_form', ['model' => $model, 'payments' => $payments]); ?>
