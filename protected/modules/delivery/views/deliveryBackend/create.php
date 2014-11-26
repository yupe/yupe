<?php
$this->breadcrumbs = [
    Yii::t('DeliveryModule.delivery', 'Способы доставки') => ['/delivery/deliveryBackend/index'],
    Yii::t('DeliveryModule.delivery', 'Добавить'),
];

$this->pageTitle = Yii::t('DeliveryModule.delivery', 'Способы доставки - добавить');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('DeliveryModule.delivery', 'Управление способами доставки'), 'url' => ['/delivery/deliveryBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('DeliveryModule.delivery', 'Добавить способ доставки'), 'url' => ['/delivery/deliveryBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('DeliveryModule.delivery', 'Способы доставки'); ?>
        <small><?php echo Yii::t('DeliveryModule.delivery', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model, 'payments' => $payments]); ?>
