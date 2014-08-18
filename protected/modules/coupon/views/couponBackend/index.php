<?php
$this->breadcrumbs = array(
    Yii::t('CouponModule.coupon', 'Купоны') => array('/coupon/couponBackend/index'),
    Yii::t('CouponModule.coupon', 'Управление'),
);

$this->pageTitle = Yii::t('CouponModule.coupon', 'Купоны - управление');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('CouponModule.coupon', 'Управление купонами'), 'url' => array('/coupon/couponBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('CouponModule.coupon', 'Добавить купон'), 'url' => array('/coupon/couponBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CouponModule.coupon', 'Купоны'); ?>
        <small><?php echo Yii::t('CouponModule.coupon', 'управление'); ?></small>
    </h1>
</div>


<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    array(
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
                'value' => 'CHtml::link($data->name, array("/coupon/couponBackend/update", "id" => $data->id))',
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
                'filter' => $model->getStatusList()
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
