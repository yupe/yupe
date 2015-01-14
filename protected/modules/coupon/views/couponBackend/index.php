<?php
$this->breadcrumbs = [
    Yii::t('CouponModule.coupon', 'Купоны') => ['/coupon/couponBackend/index'],
    Yii::t('CouponModule.coupon', 'Управление'),
];

$this->pageTitle = Yii::t('CouponModule.coupon', 'Купоны - управление');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('CouponModule.coupon', 'Управление купонами'), 'url' => ['/coupon/couponBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('CouponModule.coupon', 'Добавить купон'), 'url' => ['/coupon/couponBackend/create']],
];
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
    [
        'id' => 'coupon-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => [
            [
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/coupon/couponBackend/update", "id" => $data->id))',
            ],
            'code',
            'date_start',
            'date_end',
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/coupon/couponBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Coupon::STATUS_ACTIVE => ['class' => 'label-success'],
                    Coupon::STATUS_NOT_ACTIVE => ['class' => 'label-default'],
                ],
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
