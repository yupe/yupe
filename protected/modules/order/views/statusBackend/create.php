<?php
/**
 * @var OrderStatus $model
 */

$this->breadcrumbs = [
    Yii::t('OrderModule.order', 'Orders') => ['/order/orderBackend/index'],
    Yii::t('OrderModule.order', 'Order statuses') => ['/order/statusBackend/index'],
    Yii::t('OrderModule.order', 'Creating'),
];

$this->pageTitle = Yii::t('OrderModule.order', 'Order statuses - creating');

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
<div class="page-header">
    <h1>
        <?php echo Yii::t('OrderModule.order', 'Order statuses'); ?>
        <small><?php echo Yii::t('OrderModule.order', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
