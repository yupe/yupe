<?php
/* @var $model Order */
$this->breadcrumbs = array(
    Yii::t('ShopModule.order', 'Заказы') => array('/shop/orderBackend/index'),
    $model->name,
);

$this->pageTitle = Yii::t('ShopModule.order', 'Заказы - просмотр');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.order', 'Управление заказами'), 'url' => array('/shop/orderBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.order', 'Добавить заказ'), 'url' => array('/shop/orderBackend/create')),
    array('label' => Yii::t('ShopModule.order', 'Заказ') . ' «№' . $model->id . '»'),
    array('icon' => 'pencil', 'label' => Yii::t('ShopModule.order', 'Редактирование заказ'), 'url' => array(
        '/shop/orderBackend/update',
        'id' => $model->id
    )),
    array('icon' => 'eye-open', 'label' => Yii::t('ShopModule.order', 'Просмотреть заказ'), 'url' => array(
        '/shop/orderBackend/view',
        'id' => $model->id
    )),
    array('icon' => 'trash', 'label' => Yii::t('ShopModule.order', 'Удалить заказ'), 'url' => '#', 'linkOptions' => array(
        'submit' => array('/shop/orderBackend/delete', 'id' => $model->id),
        'confirm' => Yii::t('ShopModule.order', 'Вы уверены, что хотите удалить заказ?'),
        'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
        'csrf' => true,
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.order', 'Просмотр') . ' ' . Yii::t('ShopModule.order', 'заказа'); ?>
        <small>&laquo;№<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        array(
            'name' => 'delivery_id',
            'value' => $model->delivery->name
        ),
        'delivery_price',
        array(
            'name' => 'payment_method_id',
            'value' => $model->payment->name
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
            'value' => $model->statusTitle,
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
)); ?>
