<?php
/* @var $model Order */
$this->breadcrumbs = [
    Yii::t('OrderModule.order', 'Заказы') => ['/order/orderBackend/index'],
    $model->id,
];

$this->pageTitle = Yii::t('OrderModule.order', 'Заказы - просмотр');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('OrderModule.order', 'Управление заказами'), 'url' => ['/order/orderBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('OrderModule.order', 'Добавить заказ'), 'url' => ['/order/orderBackend/create']],
    ['label' => Yii::t('OrderModule.order', 'Заказ') . ' «№' . $model->id . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('OrderModule.order', 'Редактирование заказа'),
        'url' => [
            '/order/orderBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('OrderModule.order', 'Просмотреть заказ'),
        'url' => [
            '/order/orderBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('OrderModule.order', 'Удалить заказ'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/order/orderBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('OrderModule.order', 'Вы уверены, что хотите удалить заказ?'),
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('OrderModule.order', 'Просмотр') . ' ' . Yii::t('OrderModule.order', 'заказа'); ?>
        <small>&laquo;№<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data' => $model,
        'attributes' => [
            'id',
            [
                'name' => 'delivery_id',
                'value' => function($model){
                    return empty($model->delivery) ? '---' : $model->delivery->name;
                }
            ],
            'delivery_price',
            [
                'name' => 'payment_method_id',
                'value' => function($model){
                    return empty($model->payment) ? '---' : $model->payment->name;
                }
            ],
            'paid',
            'payment_date',
            'total_price',
            'discount',
            'coupon_discount',
            'coupon_code',
            'separate_delivery',
            [
                'name' => 'status',
                'value' => $model->getStatusTitle(),
            ],
            'date',
            [
                'name' => 'user_id',
                'type' => 'raw',
                'value' => function($model) {
                        return $model->user ?
                            CHtml::link($model->user->nick_name, ['/user/userBackend/view', 'id' => $model->user_id]) : '---';
                    },
            ],
            'name',
            'address',
            'phone',
            'email',
            'comment',
            'ip',
            'url',
            'note',
            'modified'
        ],
    ]
); ?>
