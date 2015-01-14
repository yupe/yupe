<?php
$this->breadcrumbs = [
    Yii::t('OrderModule.order', 'Заказы') => ['/order/orderBackend/index'],
    Yii::t('OrderModule.order', 'Заказ №' . $model->id) => ['/order/orderBackend/view', 'id' => $model->id],
    Yii::t('OrderModule.order', 'Редактирование'),
];

$this->pageTitle = Yii::t('OrderModule.order', 'Заказы - редактирование');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('OrderModule.order', 'Управление заказами'), 'url' => ['/order/orderBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('OrderModule.order', 'Добавить заказ'), 'url' => ['/order/orderBackend/create']],
    ['label' => Yii::t('OrderModule.order', 'Заказ') . ' «' . $model->id . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('OrderModule.order', 'Редактирование заказа'),
        'url' => [
            '/order/orderBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('OrderModule.order', 'Просмотреть заказ'),
        'url' => [
            '/order/orderBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('OrderModule.order', 'Удалить заказ'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/order/orderBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('OrderModule.order', 'Вы уверены, что хотите удалить заказ?'),
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('OrderModule.order', 'Редактирование') . ' ' . Yii::t('OrderModule.order', 'заказа'); ?>
        <small>&laquo;№<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
