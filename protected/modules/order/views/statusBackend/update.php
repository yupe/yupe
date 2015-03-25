<?php
/**
 * @var OrderStatus $model
 */

$this->breadcrumbs = [
    Yii::t('OrderModule.order', 'Orders') => ['/order/orderBackend/index'],
    Yii::t('OrderModule.order', 'Order statuses') => ['/order/statusBackend/index'],
    Yii::t('OrderModule.order', 'Edition'),
];

$this->pageTitle = Yii::t('OrderModule.order', 'Order statuses - edition');

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
            ['label' => Yii::t('OrderModule.order', 'Status') . ' «' . $model->name . '»'],
            [
                'icon' => 'fa fa-fw fa-pencil',
                'label' => Yii::t('OrderModule.order', 'Update status'),
                'url' => [
                    '/order/statusBackend/update',
                    'id' => $model->id
                ]
            ],
            [
                'icon' => 'fa fa-fw fa-trash-o',
                'label' => Yii::t('OrderModule.order', 'Delete status'),
                'url' => '#',
                'linkOptions' => [
                    'submit' => ['/order/statusBackend/delete', 'id' => $model->id],
                    'confirm' => Yii::t('OrderModule.order', 'Do you really want to remove this status?'),
                    'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
                    'csrf' => true,
                ]
            ],
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('OrderModule.order', 'Updating status'); ?>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
