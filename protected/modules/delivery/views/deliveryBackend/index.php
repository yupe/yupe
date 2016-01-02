<?php
$this->breadcrumbs = [
    Yii::t('DeliveryModule.delivery', 'Delivery methods') => ['/delivery/deliveryBackend/index'],
    Yii::t('DeliveryModule.delivery', 'Manage'),
];

$this->pageTitle = Yii::t('DeliveryModule.delivery', 'Delivery methods - manage');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('DeliveryModule.delivery', 'Manage delivery methods'), 'url' => ['/delivery/deliveryBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('DeliveryModule.delivery', 'Create delivery'), 'url' => ['/delivery/deliveryBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('DeliveryModule.delivery', 'Delivery methods'); ?>
        <small><?= Yii::t('DeliveryModule.delivery', 'manage'); ?></small>
    </h1>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'delivery-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'sortableRows' => true,
        'sortableAjaxSave' => true,
        'sortableAttribute' => 'position',
        'sortableAction' => '/delivery/deliveryBackend/sortable',
        'columns' => [
            [
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/delivery/deliveryBackend/update", "id" => $data->id))',
            ],
            'price',
            'free_from',
            'available_from',
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/delivery/deliveryBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Delivery::STATUS_ACTIVE => ['class' => 'label-success'],
                    Delivery::STATUS_NOT_ACTIVE => ['class' => 'label-default'],
                ],
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
