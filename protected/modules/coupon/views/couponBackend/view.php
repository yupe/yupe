<?php
/* @var $model Coupon */
$this->breadcrumbs = array(
    Yii::t('CouponModule.coupon', 'Купоны') => array('/coupon/couponBackend/index'),
    $model->code,
);

$this->pageTitle = Yii::t('CouponModule.coupon', 'Купоны - просмотр');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('CouponModule.coupon', 'Управление купонами'), 'url' => array('/coupon/couponBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('CouponModule.coupon', 'Добавить купон'), 'url' => array('/coupon/couponBackend/create')),
    array('label' => Yii::t('CouponModule.coupon', 'Купон') . ' «' . mb_substr($model->code, 0, 32) . '»'),
    array(
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('CouponModule.coupon', 'Редактирование купона'),
        'url' => array(
            '/coupon/couponBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('CouponModule.coupon', 'Просмотреть купон'),
        'url' => array(
            '/coupon/couponBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('CouponModule.coupon', 'Удалить купон'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/coupon/couponBackend/delete', 'id' => $model->id),
            'confirm' => Yii::t('CouponModule.coupon', 'Вы уверены, что хотите удалить купон?'),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CouponModule.coupon', 'Просмотр') . ' ' . Yii::t('CouponModule.coupon', 'купона'); ?><br/>
        <small>&laquo;<?php echo $model->code; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
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
    )
); ?>
