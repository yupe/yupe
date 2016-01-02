<?php
/* @var $model Delivery */
$this->breadcrumbs = [
    Yii::t('DeliveryModule.delivery', 'Delivery methods') => ['/delivery/deliveryBackend/index'],
    $model->name,
];

$this->pageTitle = Yii::t('DeliveryModule.delivery', 'Delivery methods - view');

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
        <?= Yii::t('DeliveryModule.delivery', 'Viewing delivery'); ?><br/>
        <small>&laquo;<?= $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'name' => 'status',
                'value' => $model->statusTitle,
            ],
            'price',
            'free_from',
            'available_from',
            'separate_payment',
            'position',
            [
                'name' => 'description',
                'type' => 'html'
            ],

        ],
    ]
); ?>
