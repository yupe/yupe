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
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('OrderModule.order', 'Manage clients'),
                'url' => ['/order/clientBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('OrderModule.order', 'Create client'),
                'url' => ['/user/userBackend/create'],
            ],
        ],
    ],
];
?>

<div>
    <h1>
        <?= Yii::t('OrderModule.order', 'Client'); ?>
        <small>&laquo;<?= $model->nick_name; ?>&raquo;</small>
    </h1>
</div>

<div class="row">
    <div class="col-sm-4">
        <?php $this->widget(
            'bootstrap.widgets.TbDetailView',
            [
                'data' => $model,
                'attributes' => [
                    [
                        'name' => 'full_name',
                        'value' => $model->getFullName(),
                    ],
                    'nick_name',
                    'email',
                    [
                        'label' => Yii::t('OrderModule.order', 'Orders'),
                        'value' => $model->getOrderNumber()
                    ],
                    [
                        'label' => Yii::t('OrderModule.order', 'Money'),
                        'value' => $model->getOrderSum()
                    ],
                    'location',
                    'site',
                    'birth_date',
                    'phone',
                    'about',
                    [
                        'name' => 'gender',
                        'value' => $model->getGender(),
                    ],
                    [
                        'name' => 'status',
                        'value' => $model->getStatus(),
                    ],
                    [
                        'name' => 'access_level',
                        'value' => $model->getAccessLevel(),
                    ],
                    [
                        'name' => 'email_confirm',
                        'value' => $model->getEmailConfirmStatus(),
                    ],
                    'visit_time',
                    'create_time',
                    'update_time',
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-8">
        <?php
        $this->widget(
            'bootstrap.widgets.TbExtendedGridView',
            [
                'id' => 'order-grid',
                'type' => 'condensed',
                'dataProvider' => $orders,
                'columns' => [
                    [
                        'name' => 'id',
                        'htmlOptions' => ['width' => '90px'],
                        'type' => 'raw',
                        'value' => function($data){
                            return CHtml::link($data->id, array("/order/orderBackend/update", "id" => $data->id));
                        },
                    ],
                    [
                        'name'   => 'date',
                        'type'   => 'html',
                        'filter' => $this->widget('booster.widgets.TbDatePicker', [
                            'model'=>$order,
                            'attribute'=>'date',
                            'options' => [
                                'format' => 'yyyy-mm-dd'
                            ],
                            'htmlOptions' => [
                                'class' => 'form-control',
                            ],
                        ], true),
                        'value' => function($data){
                            return CHtml::link($data->date, array("/order/orderBackend/update", "id" => $data->id));
                        },
                    ],
                    [
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => function($data){
                            return isset($data->client) ? CHtml::link($data->client->getFullName(), ['/order/orderBackend/view', 'id' => $data->id]) : $data->name;
                        },
                        'htmlOptions' => ['width' => '400px'],
                    ],
                    [
                        'name' => 'total_price',
                        'value' => function($data){
                            return Yii::app()->getNumberFormatter()->formatCurrency($data->total_price, Yii::app()->getModule('store')->currency);
                        }
                    ],

                    [
                        'class'   => 'yupe\widgets\EditableStatusColumn',
                        'name'    => 'status_id',
                        'url'     => $this->createUrl('/order/orderBackend/inline'),
                        'source'  => OrderStatus::model()->getList(),
                        'options' => OrderStatus::model()->getLabels(),
                    ],
                    [
                        'class'=> 'yupe\widgets\EditableStatusColumn',
                        'name' => 'paid',
                        'url'  => $this->createUrl('/order/orderBackend/inline'),
                        'source'  => $order->getPaidStatusList(),
                        'options' => [
                            Order::PAID_STATUS_NOT_PAID => ['class' => 'label-danger'],
                            Order::PAID_STATUS_PAID => ['class' => 'label-success']
                        ],
                    ],
                    [
                        'name'   => 'delivery_id',
                        'header' => Yii::t('OrderModule.order', 'Delivery'),
                        'filter' => CHtml::listData(Delivery::model()->findAll(), 'id', 'name'),
                        'value'  => function($data){
                            return $data->delivery->name;
                        }
                    ],
                ],
            ]
        ); ?>
    </div>
</div>
