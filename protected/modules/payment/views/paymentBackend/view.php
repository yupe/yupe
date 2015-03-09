<?php
/* @var $model Payment */
$this->breadcrumbs = [
    Yii::t('PaymentModule.payment', 'Payment methods') => ['/payment/paymentBackend/index'],
    $model->name
];

$this->pageTitle = Yii::t('PaymentModule.payment', 'Payment methods - view');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('PaymentModule.payment', 'Manage payment methods'), 'url' => ['/payment/paymentBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('PaymentModule.payment', 'Create payment'), 'url' => ['/payment/paymentBackend/create']],
    ['label' => Yii::t('PaymentModule.payment', 'Payment method') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('PaymentModule.payment', 'Update payment'),
        'url' => [
            '/payment/paymentBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('PaymentModule.payment', 'View payment'),
        'url' => [
            '/payment/paymentBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('PaymentModule.payment', 'Delete payment'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/payment/paymentBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('PaymentModule.payment', 'Do you really want to remove this payment method?'),
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'csrf' => true
        ]
    ]
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PaymentModule.payment', 'Viewing payment'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
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
            'module',
            'position',
            [
                'name' => 'description',
                'type' => 'html'
            ],

        ],
    ]
); ?>
