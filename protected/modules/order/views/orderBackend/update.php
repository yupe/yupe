<?php
$this->breadcrumbs = [
    Yii::t('OrderModule.order', 'Orders') => ['/order/orderBackend/index'],
    Yii::t('OrderModule.order', 'Order #{id}', ['{id}' => $model->id]) => ['/order/orderBackend/view', 'id' => $model->id],
    Yii::t('OrderModule.order', 'Edition'),
];

$this->pageTitle = Yii::t('OrderModule.order', 'Orders - edition');

$this->menu = [
    [
        'label' => Yii::t('OrderModule.order', 'Orders'),
        'items' => [
            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('OrderModule.order', 'Manage orders'), 'url' => ['/order/orderBackend/index']],
            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('OrderModule.order', 'Create order'), 'url' => ['/order/orderBackend/create']],
            ['label' => Yii::t('OrderModule.order', 'Order #') . ' «' . $model->id . '»'],
            [
                'icon' => 'fa fa-fw fa-pencil',
                'label' => Yii::t('OrderModule.order', 'Update order'),
                'url' => [
                    '/order/orderBackend/update',
                    'id' => $model->id
                ]
            ],
            [
                'icon' => 'fa fa-fw fa-eye',
                'label' => Yii::t('OrderModule.order', 'View order'),
                'url' => [
                    '/order/orderBackend/view',
                    'id' => $model->id
                ]
            ],
            [
                'icon' => 'fa fa-fw fa-trash-o',
                'label' => Yii::t('OrderModule.order', 'Delete order'),
                'url' => '#',
                'linkOptions' => [
                    'submit' => ['/order/orderBackend/delete', 'id' => $model->id],
                    'confirm' => Yii::t('OrderModule.order', 'Do you really want to remove this order?'),
                    'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
                    'csrf' => true,
                ]
            ],
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
<div class="page-header">
    <h1>
        <?= Yii::t('OrderModule.order', 'Updating order'); ?>
        <small>&laquo;<?= Yii::t('OrderModule.order', '#'); ?><?= $model->id; ?>&raquo;</small>
    </h1>
</div>

<?= $this->renderPartial('_form', ['model' => $model]); ?>

<?php if(Yii::app()->hasModule('comments') && Yii::app()->getModule('order')->enableComments):?>
    <?php $this->widget('application.modules.comment.widgets.CommentsWidget', [
            'view' => 'application.modules.order.views.orderBackend.comments',
            'redirectTo' => Yii::app()->createUrl('/order/orderBackendUpdate', ['id' => $model->id]),
            'model' => $model,
       ]); ?>
<?php endif;?>
