<?php
$this->breadcrumbs = [
    Yii::t('DeliveryModule.delivery', 'Delivery methods') => ['/delivery/deliveryBackend/index'],
    $model->name => ['/delivery/deliveryBackend/view', 'id' => $model->id],
    Yii::t('DeliveryModule.delivery', 'Edition'),
];

$this->pageTitle = Yii::t('DeliveryModule.delivery', 'Delivery methods - edition');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('DeliveryModule.delivery', 'Manage delivery methods'), 'url' => ['/delivery/deliveryBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('DeliveryModule.delivery', 'Create delivery'), 'url' => ['/delivery/deliveryBackend/create']],
    ['label' => Yii::t('DeliveryModule.delivery', 'Delivery method') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('DeliveryModule.delivery', 'Update delivery'),
        'url' => [
            '/delivery/deliveryBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('DeliveryModule.delivery', 'View delivery'),
        'url' => [
            '/delivery/deliveryBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('DeliveryModule.delivery', 'Delete delivery'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/delivery/deliveryBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('DeliveryModule.delivery', 'Do you really want to remove this delivery?'),
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('DeliveryModule.delivery', 'Updating delivery'); ?><br/>
        <small>&laquo;<?= $model->name; ?>&raquo;</small>
    </h1>
</div>
<?= $this->renderPartial('_form', ['model' => $model, 'payments' => $payments]); ?>