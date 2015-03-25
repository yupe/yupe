<?php
Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/order-backend.css');

$this->breadcrumbs = [
    Yii::t('OrderModule.order', 'Orders') => ['/order/orderBackend/index'],
    Yii::t('OrderModule.order', 'Order statuses') => ['/order/statusBackend/index'],
    Yii::t('OrderModule.order', 'Manage'),
];

$this->pageTitle = Yii::t('OrderModule.order', 'Order statuses - manage');

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
        <?php echo Yii::t('OrderModule.order', 'Order statuses'); ?>
        <small><?php echo Yii::t('OrderModule.order', 'manage'); ?></small>
    </h1>
</div>


<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'status-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'actionsButtons' => [
            'add' => CHtml::link(
                Yii::t('OrderModule.order', 'Add'),
                ['/order/statusBackend/create'],
                ['class' => 'btn btn-sm btn-success pull-right']
            ),
        ],
        'columns' => [
            [
                'name' => 'id',
                'htmlOptions' => ['width' => '50px'],
                'filter' => false,
            ],
            'name',
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => [
                        'visible' => function ($row, $data) {
                            return !$data->is_system ? true: false;
                        }
                    ],
                    'delete' => [
                        'visible' => function ($row, $data) {
                            return !$data->is_system ? true: false;
                        }
                    ],
                ],
            ],
        ],
    ]
); ?>
