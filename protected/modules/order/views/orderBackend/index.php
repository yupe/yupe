<?php
Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/order-backend.css');

$this->breadcrumbs = [
    Yii::t('OrderModule.order', 'Orders') => ['/order/orderBackend/index'],
    Yii::t('OrderModule.order', 'Manage'),
];

$this->pageTitle = Yii::t('OrderModule.order', 'Orders - manage');

$this->menu = [
    [
        'label' => Yii::t('OrderModule.order', 'Orders'),
        'items' => [
            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('OrderModule.order', 'Manage orders'), 'url' => ['/order/orderBackend/index']],
            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('OrderModule.order', 'Create order'), 'url' => ['/order/orderBackend/create']],
        ]
    ],
    [
        'label' => Yii::t('OrderModule.order', 'Order statuses'),
        'items' => [
            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('OrderModule.order', 'Manage statuses'), 'url' => ['/order/statusBackend/index']],
            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('OrderModule.order', 'Create status'), 'url' => ['/order/statusBackend/create']],
        ]
    ],
];
?>
<div class="">
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
        'datePickers'=> ['Order_date'],
        'afterAjaxUpdate' => 'reinstallDatePicker',
        'columns' => [
            [
                'name' => 'id',
                'htmlOptions' => ['width' => '90px'],
                'type' => 'raw',
                'value' => 'CHtml::link(Yii::t("OrderModule.order", "Order #").$data->id, array("/order/orderBackend/update", "id" => $data->id))',
            ],
            [
                'name'   => 'date',
                'filter' => $this->widget('booster.widgets.TbDatePicker', [
                            'model'=>$model,
                            'attribute'=>'date',
                            'options' => [
                                'format' => 'yyyy-mm-dd'
                            ],
                            'htmlOptions' => [
                                'class' => 'form-control',
                            ],
                        ], true)
            ],
            [
                'name' => 'name',
                'type' => 'raw',
                'value' => '$data->name . ($data->note ? "<br><div class=\"note\">$data->note</div>" : "")',
                'htmlOptions' => ['width' => '400px'],
            ],
            [
                'name' => 'total_price',
                'value' => 'Yii::app()->numberFormatter->formatCurrency($data->getTotalPriceWithDelivery(), "RUB")'
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
                'source'  => $model->getPaidStatusList(),
                'options' => [
                    Order::PAID_STATUS_NOT_PAID => ['class' => 'label-danger'],
                    Order::PAID_STATUS_PAID => ['class' => 'label-success']
                ],
            ],
            [
                'name'   => 'payment_time',
                'filter' => $this->widget('booster.widgets.TbDatePicker', [
                            'model'=>$model,
                            'attribute'=>'payment_time',
                            'options' => [
                                'format' => 'yyyy-mm-dd'
                            ],
                            'htmlOptions' => [
                                'class' => 'form-control',
                            ],
                        ], true)
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
