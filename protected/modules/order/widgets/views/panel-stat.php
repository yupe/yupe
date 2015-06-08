<?php
/**
 * @var $ordersCount int
 * @var $newOrdersCount int
 * @var $dataProvider CActiveDataProvider
 */
?>
<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbCollapse', [
        'htmlOptions' => [
            'id' => 'panel-order-stat'
        ]
    ]
);?>

<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#<?= $this->getId(); ?>">
                    <i class="fa fa-gift"></i> <?php echo Yii::t('OrderModule.order', 'Orders'); ?>
                </a>
                <span class="badge alert-success"><?php echo Yii::t('OrderModule.order', 'New'); ?>: <?php echo $newOrdersCount; ?></span>
                <span class="badge alert-info"><?php echo Yii::t('OrderModule.order', 'Total'); ?>: <?php echo $ordersCount; ?></span>
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
                                    'class' => false
                                ],
                                'columns' => [
                                    [
                                        'name' => 'id',
                                        'htmlOptions' => ['width' => '90px'],
                                        'type' => 'raw',
                                        'value' => function ($data) {
                                            return CHtml::link(Yii::t('OrderModule.order', 'Order #') . $data->id, ["/order/orderBackend/update", "id" => $data->id]);
                                        },
                                    ],
                                    [
                                        'name' => 'date'
                                    ],
                                    [
                                        'name' => 'name',
                                        'htmlOptions' => ['width' => '400px'],
                                    ],
                                    'total_price',
                                    [
                                        'name' => 'status_id',
                                        'value' => function ($data) {
                                            return $data->status->getTitle();
                                        },
                                    ],
                                    [
                                        'name' => 'paid',
                                        'value' => function ($data) {
                                            return $data->getPaidStatus();
                                        },
                                    ],
                                    'payment_time',
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
