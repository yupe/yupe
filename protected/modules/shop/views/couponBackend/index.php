<?php
$this->breadcrumbs = array(
    Yii::t('ShopModule.coupon', 'Купоны') => array('/shop/couponBackend/index'),
    Yii::t('ShopModule.coupon', 'Управление'),
);

$this->pageTitle = Yii::t('ShopModule.coupon', 'Купоны - управление');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.coupon', 'Управление купонами'), 'url' => array('/shop/couponBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.coupon', 'Добавить купон'), 'url' => array('/shop/couponBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.coupon', 'Купоны'); ?>
        <small><?php echo Yii::t('ShopModule.coupon', 'управление'); ?></small>
    </h1>
</div>


<?php
$this->widget('yupe\widgets\CustomGridView', array(
    'id' => 'coupon-grid',
    'type' => 'condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id',
            'htmlOptions' => array('style' => 'width: 40px'),
        ),
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name, array("/shop/couponBackend/update", "id" => $data->id))',
        ),
        'code',
        /*array(
            'name' => 'type',
            'value' => '$data->getTypeTitle()',
        ),
        'value',
        'min_order_price',
        'registered_user:boolean',
        'free_shipping:boolean',
        'date_start',
        'date_end',
        'quantity',
        'quantity_per_user',*/
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("time", "ok-sign", "minus-sign"))',
            'filter' => $model->getStatusList()
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>
