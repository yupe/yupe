<?php
$this->breadcrumbs = array(
    Yii::t('ShopModule.coupon', 'Купоны') => array('/shop/couponBackend/index'),
    $model->code => array('/shop/couponBackend/view', 'id' => $model->id),
    Yii::t('ShopModule.coupon', 'Редактирование'),
);

$this->pageTitle = Yii::t('ShopModule.coupon', 'Купоны - редактирование');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.coupon', 'Управление купонами'), 'url' => array('/shop/couponBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.coupon', 'Добавить купон'), 'url' => array('/shop/couponBackend/create')),
    array('label' => Yii::t('ShopModule.coupon', 'Производитель') . ' «' . mb_substr($model->code, 0, 32) . '»'),
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
            <?php echo Yii::t('ShopModule.coupon', 'Редактирование') . ' ' . Yii::t('ShopModule.coupon', 'купона'); ?><br/>
            <small>&laquo;<?php echo $model->code; ?>&raquo;</small>
        </h1>
    </div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>