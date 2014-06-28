<?php
/* @var $model Coupon */
$this->breadcrumbs = array(
    Yii::t('ShopModule.coupon', 'Купоны') => array('/shop/couponBackend/index'),
    $model->code,
);

$this->pageTitle = Yii::t('ShopModule.coupon', 'Купоны - просмотр');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.coupon', 'Управление купонами'), 'url' => array('/shop/couponBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.coupon', 'Добавить купон'), 'url' => array('/shop/couponBackend/create')),
    array('label' => Yii::t('ShopModule.coupon', 'Купон') . ' «' . mb_substr($model->code, 0, 32) . '»'),
    array('icon' => 'pencil', 'label' => Yii::t('ShopModule.coupon', 'Редактирование купона'), 'url' => array(
        '/shop/couponBackend/update',
        'id' => $model->id
    )),
    array('icon' => 'eye-open', 'label' => Yii::t('ShopModule.coupon', 'Просмотреть купон'), 'url' => array(
        '/shop/couponBackend/view',
        'id' => $model->id
    )),
    array('icon' => 'trash', 'label' => Yii::t('ShopModule.coupon', 'Удалить купон'), 'url' => '#', 'linkOptions' => array(
        'submit' => array('/shop/couponBackend/delete', 'id' => $model->id),
        'confirm' => Yii::t('ShopModule.coupon', 'Вы уверены, что хотите удалить купон?'),
        'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
        'csrf' => true,
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.coupon', 'Просмотр') . ' ' . Yii::t('ShopModule.coupon', 'купона'); ?><br/>
        <small>&laquo;<?php echo $model->code; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'name',
        'code',
        array(
            'name' => 'type',
            'value' => $model->getTypeTitle(),
        ),
        'value',
        'min_order_price',
        'registered_user:boolean',
        'free_shipping:boolean',
        'date_start',
        'date_end',
        'quantity',
        'quantity_per_user',
        array(
            'name' => 'status',
            'value' => $model->statusTitle,
        ),

    ),
)); ?>
