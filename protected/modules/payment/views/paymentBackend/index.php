<?php
$this->breadcrumbs = [
    Yii::t('PaymentModule.payment', 'Способы оплаты') => ['/payment/paymentBackend/index'],
    Yii::t('PaymentModule.payment', 'Управление')
];

$this->pageTitle = Yii::t('PaymentModule.payment', 'Способы оплаты - управление');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('PaymentModule.payment', 'Управление способами оплаты'), 'url' => ['/payment/paymentBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('PaymentModule.payment', 'Добавить способ оплаты'), 'url' => ['/payment/paymentBackend/create']]
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PaymentModule.payment', 'Способы оплаты'); ?>
        <small><?php echo Yii::t('PaymentModule.payment', 'управление'); ?></small>
    </h1>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'payment-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'sortableRows' => true,
        'sortableAjaxSave' => true,
        'sortableAttribute' => 'position',
        'sortableAction' => '/payment/paymentBackend/sortable',
        'columns' => [
            [
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/payment/paymentBackend/update", "id" => $data->id))'
            ],
            'module',
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/payment/paymentBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Payment::STATUS_ACTIVE => ['class' => 'label-success'],
                    Payment::STATUS_NOT_ACTIVE => ['class' => 'label-default']
                ]
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn'
            ]
        ]
    ]
); ?>
