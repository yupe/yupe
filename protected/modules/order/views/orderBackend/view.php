<?php
/* @var $model Order */
$this->breadcrumbs = array(
    Yii::t('OrderModule.order', 'Заказы') => array('/order/orderBackend/index'),
    $model->id,
);

$this->pageTitle = Yii::t('OrderModule.order', 'Заказы - просмотр');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('OrderModule.order', 'Управление заказами'), 'url' => array('/order/orderBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('OrderModule.order', 'Добавить заказ'), 'url' => array('/order/orderBackend/create')),
    array('label' => Yii::t('OrderModule.order', 'Заказ') . ' «№' . $model->id . '»'),
    array(
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('OrderModule.order', 'Редактирование заказа'),
        'url' => array(
            '/order/orderBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('OrderModule.order', 'Просмотреть заказ'),
        'url' => array(
            '/order/orderBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('OrderModule.order', 'Удалить заказ'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/order/orderBackend/delete', 'id' => $model->id),
            'confirm' => Yii::t('OrderModule.order', 'Вы уверены, что хотите удалить заказ?'),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('OrderModule.order', 'Просмотр') . ' ' . Yii::t('OrderModule.order', 'заказа'); ?>
        <small>&laquo;№<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data' => $model,
        'attributes' => array(
            'id',
            array(
                'name' => 'delivery_id',
                'value' => function($model){
                    return empty($model->delivery) ? '---' : $model->delivery->name;
                }
            ),
            'delivery_price',
            array(
                'name' => 'payment_method_id',
                'value' => function($model){
                    return empty($model->payment) ? '---' : $model->payment->name;
                }
            ),
            'paid',
            'payment_date',
            'total_price',
            'discount',
            'coupon_discount',
            'coupon_code',
            'separate_delivery',
            array(
                'name' => 'status',
                'value' => $model->getStatusTitle(),
            ),
            'date',
            array(
                'name' => 'user_id',
                'type' => 'raw',
                'value' => CHtml::link($model->user->nick_name, array('/user/userBackend/view', 'id' => $model->user_id)),
            ),
            'name',
            'address',
            'phone',
            'email',
            'comment',
            'ip',
            'url',
            'note',
            'modified'
        ),
    )
); ?>
