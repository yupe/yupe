<?php
/* @var $model Payment */
$this->breadcrumbs = array(
    Yii::t('ShopModule.payment', 'Способы оплаты') => array('/shop/paymentBackend/index'),
    $model->name,
);

$this->pageTitle = Yii::t('ShopModule.payment', 'Способы оплаты - просмотр');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.payment', 'Управление способами оплаты'), 'url' => array('/shop/paymentBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.payment', 'Добавить способ оплаты'), 'url' => array('/shop/paymentBackend/create')),
    array('label' => Yii::t('ShopModule.payment', 'Способ оплаты') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array('icon' => 'pencil', 'label' => Yii::t('ShopModule.payment', 'Редактирование способ оплаты'), 'url' => array(
        '/shop/paymentBackend/update',
        'id' => $model->id
    )),
    array('icon' => 'eye-open', 'label' => Yii::t('ShopModule.payment', 'Просмотреть способ оплаты'), 'url' => array(
        '/shop/paymentBackend/view',
        'id' => $model->id
    )),
    array('icon' => 'trash', 'label' => Yii::t('ShopModule.payment', 'Удалить способ оплаты'), 'url' => '#', 'linkOptions' => array(
        'submit'  => array('/shop/paymentBackend/delete', 'id' => $model->id),
        'confirm' => Yii::t('ShopModule.payment', 'Вы уверены, что хотите удалить способ оплаты?'),
        'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
        'csrf' => true,
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.payment', 'Просмотр') . ' ' . Yii::t('ShopModule.payment', 'способа оплаты'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'name',
        array(
            'name' => 'status',
            'value' => $model->statusTitle,
        ),
        'module',
        'position',
        array(
            'name' => 'description',
            'type' => 'html'
        ),

    ),
)); ?>
