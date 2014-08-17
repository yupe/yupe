<?php
$this->breadcrumbs = array(
    Yii::t('CouponModule.coupon', 'Купоны') => array('/coupon/couponBackend/index'),
    $model->code => array('/coupon/couponBackend/view', 'id' => $model->id),
    Yii::t('CouponModule.coupon', 'Редактирование'),
);

$this->pageTitle = Yii::t('CouponModule.coupon', 'Купоны - редактирование');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('CouponModule.coupon', 'Управление купонами'), 'url' => array('/coupon/couponBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('CouponModule.coupon', 'Добавить купон'), 'url' => array('/coupon/couponBackend/create')),
    array('label' => Yii::t('CouponModule.coupon', 'Производитель') . ' «' . mb_substr($model->code, 0, 32) . '»'),
    array(
        'icon' => 'glyphicon glyphicon-pencil',
        'label' => Yii::t('CouponModule.coupon', 'Редактирование купона'),
        'url' => array(
            '/coupon/couponBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-eye-open',
        'label' => Yii::t('CouponModule.coupon', 'Просмотреть купон'),
        'url' => array(
            '/coupon/couponBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-trash',
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
        <?php echo Yii::t('CouponModule.coupon', 'Редактирование') . ' ' . Yii::t('CouponModule.coupon', 'купона'); ?><br/>
        <small>&laquo;<?php echo $model->code; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
