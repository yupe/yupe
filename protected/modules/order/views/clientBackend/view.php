<?php
Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/order-backend.css');

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
                        'value' => CHtml::link($model->getOrderNumber(),
                            ['/order/orderBackend/index', 'Order[user_id]' => $model->id]),
                        'type' => 'html',
                    ],
                    'birth_date',
                    'phone',
                    [
                        'label' => Yii::t('OrderModule.order', 'Money'),
                        'value' => '<span class="label label-success">'.Yii::app()->numberFormatter->formatCurrency($model->getOrderSum(),
                                Yii::app()->getModule('store')->currency)."</span>",
                        'type' => 'html',
                    ],
                    'location',
                    'site',
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
                        'name' => 'email_confirm',
                        'value' => $model->getEmailConfirmStatus(),
                    ],
                    [
                        'name' => 'visit_time',
                        'value' => Yii::app()->getDateFormatter()->formatDateTime($model->visit_time),
                    ],
                    [
                        'name' => 'create_time',
                        'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_time),
                    ],
                    [
                        'name' => 'update_time',
                        'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_time),
                    ],
                ],
            ]
        ); ?>
    </div>

    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-12">
                <?php
                $this->widget(
                    'bootstrap.widgets.TbExtendedGridView',
                    [
                        'id' => 'order-grid',
                        'type' => 'condensed',
                        'dataProvider' => $orders,
                        'template' => '{items}{pager}',
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
                                    'model' => $order,
                                    'attribute' => 'date',
                                    'options' => [
                                        'format' => 'yyyy-mm-dd',
                                    ],
                                    'htmlOptions' => [
                                        'class' => 'form-control',
                                    ],
                                ], true),
                                'value' => function ($data) {
                                    return CHtml::link(Yii::app()->getDateFormatter()->formatDateTime($data->date,
                                        'short',
                                        false), ["/order/orderBackend/update", "id" => $data->id]);
                                },
                            ],
                            [
                                'name' => 'total_price',
                                'value' => function ($data) {
                                    return Yii::app()->getNumberFormatter()->formatCurrency($data->total_price,
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
                                'class' => 'yupe\widgets\EditableStatusColumn',
                                'name' => 'paid',
                                'url' => $this->createUrl('/order/orderBackend/inline'),
                                'source' => $order->getPaidStatusList(),
                                'options' => [
                                    Order::PAID_STATUS_NOT_PAID => ['class' => 'label-danger'],
                                    Order::PAID_STATUS_PAID => ['class' => 'label-success'],
                                ],
                            ],
                            [
                                'name' => 'delivery_id',
                                'header' => Yii::t('OrderModule.order', 'Delivery'),
                                'filter' => CHtml::listData(Delivery::model()->findAll(), 'id', 'name'),
                                'value' => function ($data) {
                                    return $data->delivery->name;
                                },
                            ],
                        ],
                    ]
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (Yii::app()->hasModule('comment')): ?>
                    <?php $this->widget('application.modules.comment.widgets.CommentsWidget', [
                        'view' => 'application.modules.order.views.orderBackend.comments',
                        'redirectTo' => Yii::app()->createUrl('/order/clientBackend/view', ['id' => $model->id]),
                        'model' => $model,
                    ]); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
