<?php
$this->breadcrumbs = array(
    Yii::t('CouponModule.coupon', 'Купоны') => array('/coupon/couponBackend/index'),
    Yii::t('CouponModule.coupon', 'Управление'),
);

$this->pageTitle = Yii::t('CouponModule.coupon', 'Купоны - управление');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('CouponModule.coupon', 'Управление купонами'), 'url' => array('/coupon/couponBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('CouponModule.coupon', 'Добавить купон'), 'url' => array('/coupon/couponBackend/create')),
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
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/coupon/couponBackend/update", "id" => $data->id))',
            ),
            'code',
            'date_start',
            'date_end',
            array(
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/coupon/couponBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Coupon::STATUS_ACTIVE => ['class' => 'label-success'],
                    Coupon::STATUS_NOT_ACTIVE => ['class' => 'label-default'],
                ],
            ),
            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
); ?>
