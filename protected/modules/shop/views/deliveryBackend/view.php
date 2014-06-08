<?php
/* @var $model Delivery */
$this->breadcrumbs = array(
    Yii::t('ShopModule.delivery', 'Способы доставки') => array('/shop/deliveryBackend/index'),
    $model->name,
);

$this->pageTitle = Yii::t('ShopModule.delivery', 'Способы доставки - просмотр');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.delivery', 'Управление способами доставки'), 'url' => array('/shop/deliveryBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.delivery', 'Добавить способ доставки'), 'url' => array('/shop/deliveryBackend/create')),
    array('label' => Yii::t('ShopModule.delivery', 'Способ доставки') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array('icon' => 'pencil', 'label' => Yii::t('ShopModule.delivery', 'Редактирование способ доставки'), 'url' => array(
        '/shop/deliveryBackend/update',
        'id' => $model->id
    )),
    array('icon' => 'eye-open', 'label' => Yii::t('ShopModule.delivery', 'Просмотреть способ доставки'), 'url' => array(
        '/shop/deliveryBackend/view',
        'id' => $model->id
    )),
    array('icon' => 'trash', 'label' => Yii::t('ShopModule.delivery', 'Удалить способ доставки'), 'url' => '#', 'linkOptions' => array(
        'submit'  => array('/shop/deliveryBackend/delete', 'id' => $model->id),
        'confirm' => Yii::t('ShopModule.delivery', 'Вы уверены, что хотите удалить способ доставки?'),
        'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
        'csrf' => true,
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.delivery', 'Просмотр') . ' ' . Yii::t('ShopModule.delivery', 'способа доставки'); ?><br/>
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
        'price',
        'free_from',
        'available_from',
        'separate_payment',
        'position',
        array(
            'name' => 'description',
            'type' => 'html'
        ),

    ),
)); ?>
