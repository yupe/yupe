<?php
$this->breadcrumbs = [
    Yii::t('CouponModule.coupon', 'Купоны') => ['/coupon/couponBackend/index'],
    $model->code => ['/coupon/couponBackend/view', 'id' => $model->id],
    Yii::t('CouponModule.coupon', 'Редактирование'),
];

$this->pageTitle = Yii::t('CouponModule.coupon', 'Купоны - редактирование');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('CouponModule.coupon', 'Управление купонами'), 'url' => ['/coupon/couponBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('CouponModule.coupon', 'Добавить купон'), 'url' => ['/coupon/couponBackend/create']],
    ['label' => Yii::t('CouponModule.coupon', 'Производитель') . ' «' . mb_substr($model->code, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('CouponModule.coupon', 'Редактирование купона'),
        'url' => [
            '/coupon/couponBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('CouponModule.coupon', 'Просмотреть купон'),
        'url' => [
            '/coupon/couponBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('CouponModule.coupon', 'Удалить купон'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/coupon/couponBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('CouponModule.coupon', 'Вы уверены, что хотите удалить купон?'),
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CouponModule.coupon', 'Редактирование') . ' ' . Yii::t('CouponModule.coupon', 'купона'); ?><br/>
        <small>&laquo;<?php echo $model->code; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
