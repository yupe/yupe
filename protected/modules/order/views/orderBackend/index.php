<?php
Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl().'/css/order-backend.css');

$this->breadcrumbs = [
    Yii::t('OrderModule.order', 'Orders') => ['/order/orderBackend/index'],
    Yii::t('OrderModule.order', 'Manage'),
];

$this->pageTitle = Yii::t('OrderModule.order', 'Orders - manage');

$this->menu = [
    [
        'label' => Yii::t('OrderModule.order', 'Orders'),
        'items' => [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('OrderModule.order', 'Manage orders'),
                'url' => ['/order/orderBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('OrderModule.order', 'Create order'),
                'url' => ['/order/orderBackend/create'],
            ],
        ],
    ],
    [
        'label' => Yii::t('OrderModule.order', 'Order statuses'),
        'items' => [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('OrderModule.order', 'Manage statuses'),
                'url' => ['/order/statusBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('OrderModule.order', 'Create status'),
                'url' => ['/order/statusBackend/create'],
            ],
        ],
    ],
];
?>
<div>
    <h1>
        <?= Yii::t('OrderModule.order', 'Orders'); ?>
        <small><?= Yii::t('OrderModule.order', 'manage'); ?></small>
    </h1>
</div>


<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'order-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'datePickers' => ['Order_date'],
        'afterAjaxUpdate' => 'reinstallDatePicker',
        'columns' => [
            [
                'name' => 'id',
                'htmlOptions' => ['width' => '90px'],
                'type' => 'raw',
                'value' => function ($data) {
                    return CHtml::link($data->id, ["/order/orderBackend/update", "id" => $data->id]);
                },
            ],
            [
                'name' => 'date',
                'type' => 'html',
                'filter' => $this->widget('booster.widgets.TbDatePicker', [
                    'model' => $model,
                    'attribute' => 'date',
                    'options' => [
                        'format' => 'yyyy-mm-dd',
                    ],
                    'htmlOptions' => [
                        'class' => 'form-control',
                    ],
                ], true),
                'value' => function ($data) {
                    return CHtml::link(Yii::app()->getDateFormatter()->formatDateTime($data->date, 'medium'),
                        ["/order/orderBackend/update", "id" => $data->id]);
                },
            ],
            [
                'name' => 'name',
                'type' => 'raw',
                'value' => function ($data) {
                    return isset($data->client) ? CHtml::link(CHtml::encode($data->client->getFullName()),
                        ['/order/clientBackend/view', 'id' => $data->user_id]) : CHtml::encode($data->name);
                },
                'htmlOptions' => ['width' => '400px'],
            ],
            [
                'name' => 'total_price',
                'value' => function ($data) {
                    return Yii::app()->getNumberFormatter()->formatCurrency($data->getTotalPriceWithDelivery(),
                        Yii::app()->getModule('store')->currency);
                },
            ],
            [
                'class' => 'yupe\widgets\EditableStatusColumn',
                'name' => 'status_id',
                'url' => $this->createUrl('/order/orderBackend/inline'),
                'source' => OrderHelper::statusList(),
                'options' => OrderHelper::labelList(),
            ],
            [
                'name' => 'payment_method_id',
                'value' => function ($data) {
                    return $data->payment ? $data->payment->name : '---';
                },
                'filter' => CHtml::listData(Payment::model()->findAll(), 'id', 'name'),
            ],
            [
                'class' => 'yupe\widgets\EditableStatusColumn',
                'name' => 'paid',
                'url' => $this->createUrl('/order/orderBackend/inline'),
                'source' => $model->getPaidStatusList(),
                'options' => [
                    Order::PAID_STATUS_NOT_PAID => ['class' => 'label-danger'],
                    Order::PAID_STATUS_PAID => ['class' => 'label-success'],
                ],
            ],
            [
                'name' => 'delivery_id',
                'header' => Yii::t('OrderModule.order', 'Delivery'),
                'filter' => CHtml::listData(Delivery::model()->findAll(), 'id', 'name'),
                'value' => function (Order $data) {
                    return $data->delivery->name;
                },
            ],
            [
                'name' => 'manager_id',
                'type' => 'raw',
                'filter' => CHtml::listData(
                    User::model()->findAll('access_level = :level', [':level' => User::ACCESS_LEVEL_ADMIN]),
                    'id',
                    'fullName'
                ),
                'value' => function ($data) {
                    return isset($data->manager) ? \yupe\helpers\YText::shortName($data->manager->getFullName()) : null;
                },
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
                'buttons' => [
                    'update' => [
                        'visible' => function ($row, Order $order) {
                            return $order->checkManager(Yii::app()->getUser());
                        },
                    ],
                    'delete' => [
                        'visible' => function ($row, Order $order) {
                            return $order->checkManager(Yii::app()->getUser());
                        },
                    ],
                ],
            ],
        ],
    ]
); ?>
