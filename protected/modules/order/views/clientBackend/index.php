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
                'value'  => function($data){
                    return CHtml::link($data->getOrderNumber(), ['/order/orderBackend/index', 'Order[user_id]' => $data->id]);
                },
            ],
            [
                'name'   => 'ordersTotalSum',
                'header' => Yii::t('OrderModule.order', 'Money'),
                'value' => function($data){
                    return Yii::app()->numberFormatter->formatCurrency($data->getOrderSum(), Yii::app()->getModule('store')->currency);
                }
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
