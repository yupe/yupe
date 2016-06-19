<?php
Yii::app()->getClientScript()->registerCssFile(Yii::app()->getModule('order')->getAssetsUrl() . '/css/order-backend.css');
/**
 * @var $ordersCount int
 * @var $newOrdersCount int
 * @var $dataProvider CActiveDataProvider
 */
?>
<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbCollapse',
    [
        'htmlOptions' => [
            'id' => 'panel-order-stat',
        ],
    ]
); ?>

<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#<?= $this->getId(); ?>">
                    <i class="fa fa-gift"></i> <?= Yii::t('OrderModule.order', 'Orders'); ?>
                </a>
                <span class="badge alert-success"><?= Yii::t('OrderModule.order', 'New'); ?>
                    : <?= $newOrdersCount; ?></span>
                <span class="badge alert-info"><?= Yii::t('OrderModule.order', 'Total'); ?>: <?= $ordersCount; ?></span>
            </h4>
        </div>

        <div id="<?= $this->getId(); ?>" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <?php $this->widget(
                            'bootstrap.widgets.TbExtendedGridView',
                            [
                                'id' => 'orders-grid',
                                'type' => 'striped condensed',
                                'dataProvider' => $dataProvider,
                                'template' => '{items}',
                                'htmlOptions' => [
                                    'class' => false,
                                ],
                                'columns' => [
                                    [
                                        'name' => 'id',
                                        'htmlOptions' => ['width' => '90px'],
                                        'type' => 'raw',
                                        'value' => function ($data) {
                                            return CHtml::link(
                                                Yii::t('OrderModule.order', 'Order #').$data->id,
                                                ["/order/orderBackend/update", "id" => $data->id]
                                            );
                                        },
                                    ],
                                    [
                                        'name' => 'date',
                                        'value' => function($data){
                                            return CHtml::link(Yii::app()->getDateFormatter()->formatDateTime($data->date, 'medium'), array("/order/orderBackend/update", "id" => $data->id));
                                        },
                                        'type' => 'raw'
                                    ],
                                    [
                                        'name' => 'name',
                                        'htmlOptions' => ['width' => '400px'],
                                    ],
                                    [
                                        'name' => 'total_price',
                                        'value' => function ($data) {
                                            return Yii::app()->getNumberFormatter()->formatCurrency(
                                                $data->total_price,
                                                Yii::app()->getModule('store')->currency
                                            );
                                        },
                                    ],
                                    [
                                        'class' => 'yupe\widgets\EditableStatusColumn',
                                        'name' => 'status_id',
                                        'url' => $this->controller->createUrl('/order/orderBackend/inline'),
                                        'source' => OrderHelper::statusList(),
                                        'options' => OrderHelper::labelList(),
                                    ],
                                    [
                                        'class' => 'yupe\widgets\EditableStatusColumn',
                                        'name' => 'paid',
                                        'url' => $this->controller->createUrl('/order/orderBackend/inline'),
                                        'source' => Order::model()->getPaidStatusList(),
                                        'options' => [
                                            Order::PAID_STATUS_NOT_PAID => ['class' => 'label-danger'],
                                            Order::PAID_STATUS_PAID => ['class' => 'label-success'],
                                        ],
                                    ],
                                ],
                            ]
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
