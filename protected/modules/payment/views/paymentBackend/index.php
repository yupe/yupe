<?php
$this->breadcrumbs = [
    Yii::t('PaymentModule.payment', 'Payment methods') => ['/payment/paymentBackend/index'],
    Yii::t('PaymentModule.payment', 'Manage')
];

$this->pageTitle = Yii::t('PaymentModule.payment', 'Payment methods - manage');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('PaymentModule.payment', 'Manage payment methods'), 'url' => ['/payment/paymentBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('PaymentModule.payment', 'Create payment'), 'url' => ['/payment/paymentBackend/create']]
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('PaymentModule.payment', 'Payment methods'); ?>
        <small><?= Yii::t('PaymentModule.payment', 'administration'); ?></small>
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
                'value' => function($data){
                    return CHtml::link($data->name, ["/payment/paymentBackend/update", "id" => $data->id]);
                }
            ],
            [
                'name' => 'module',
                'value' => function($data){
                    return $data->module ? $data->module : Yii::t('PaymentModule.payment', 'Manual processing');
                }
            ],
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
                'class' => 'yupe\widgets\CustomButtonColumn',
                'template' => '{update}{delete}'
            ]
        ]
    ]
); ?>
