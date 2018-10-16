<?php

$this->breadcrumbs = [
    Yii::t('OrderModule.order', 'Clients') => ['/order/clientBackend/index'],
    Yii::t('OrderModule.order', 'Manage'),
];

$this->pageTitle = Yii::t('OrderModule.order', 'Clients - manage');

$this->menu = [
    [
        'label' => Yii::t('OrderModule.order', 'Clients'),
        'items' => [
            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('OrderModule.order', 'Manage clients'), 'url' => ['/order/clientBackend/index']],
            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('OrderModule.order', 'Create client'), 'url' => ['/user/userBackend/create']],
        ]
    ]
];
?>
<div>
    <h1>
        <?= Yii::t('OrderModule.order', 'Clients'); ?>
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
        'actionsButtons' => [
            CHtml::link(
                Yii::t('OrderModule.order', 'Add'),
                ['/user/userBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns' => [
            [
                'name' => 'last_name',
                'type' => 'html',
                'value' => function($data){
                    return CHtml::link($data->last_name, ['/order/clientBackend/view', 'id' => $data->id]);
                }
            ],
            [
                'name' => 'first_name',
                'type' => 'html',
                'value' => function($data){
                    return CHtml::link($data->first_name, ['/order/clientBackend/view', 'id' => $data->id]);
                }
            ],
            [
                'name' => 'middle_name',
                'type' => 'html',
                'value' => function($data){
                    return CHtml::link($data->middle_name, ['/order/clientBackend/view', 'id' => $data->id]);
                }
            ],
            [
                'name' => 'email',
                'type' => 'html',
                'value' => function($data){
                    return CHtml::link($data->email, ['/order/clientBackend/view', 'id' => $data->id]);
                }
            ],
            [
                'name' => 'phone',
                'type' => 'html',
                'value' => function($data){
                    return CHtml::link($data->phone, ['/order/clientBackend/view', 'id' => $data->id]);
                }
            ],
            [
                'name'   => 'ordersTotalNumber',
                'header' => Yii::t('OrderModule.order', 'Orders'),
                'type'   => 'html',
                'value'  => function(Client $client){
                    $data = CHtml::link($client->getOrderNumber(), ['/order/orderBackend/index', 'Order[user_id]' => $client->id]);
                    $order = $client->getLastOrder();
                    if($order) {
                        $data .= ' <span class="label label-default">'.CHtml::link($order->id, ['/order/orderBackend/update', 'id' => $order->id]).' '.Yii::t('OrderModule.order', 'from').' '.Yii::app()->getDateFormatter()->formatDateTime($order->date, 'short', false).'</span>';
                    }
                    return $data;
                },
            ],
            [
                'name'   => 'ordersTotalSum',
                'header' => Yii::t('OrderModule.order', 'Money'),
                'value' => function($data){
                    return '<span class="label label-default">'.Yii::app()->numberFormatter->formatCurrency($data->getOrderSum(), Yii::app()->getModule('store')->currency).'</span>';
                },
                'type' => 'html'
            ],
            [
                'name'   => 'create_time',
                'filter' => false,
                'value'  => function($data){
                    return Yii::app()->getDateFormatter()->formatDateTime($data->create_time, 'short', false);
                },
            ],
            [
                'name'   => 'visit_time',
                'value'  => function($data){
                    return Yii::app()->getDateFormatter()->formatDateTime($data->visit_time, 'short', false);
                },
                'filter' => false
            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/user/userBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    User::STATUS_ACTIVE     => ['class' => 'label-success'],
                    User::STATUS_BLOCK      => ['class' => 'label-danger'],
                    User::STATUS_NOT_ACTIVE => ['class' => 'label-warning'],
                ],
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
                'buttons' => [
                    'update' => [
                        'url' => '["/user/userBackend/update", "id" => $data->id]'
                    ],
                    'delete' => [
                        'url' => '["/user/userBackend/delete", "id" => $data->id]'
                    ]
                ]
            ],
        ],
    ]
); ?>
