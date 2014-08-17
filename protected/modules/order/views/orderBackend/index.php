<?php
$this->breadcrumbs = array(
    Yii::t('OrderModule.order', 'Заказы') => array('/order/orderBackend/index'),
    Yii::t('OrderModule.order', 'Управление'),
);

$this->pageTitle = Yii::t('OrderModule.order', 'Заказы - управление');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('OrderModule.order', 'Управление заказами'), 'url' => array('/order/orderBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('OrderModule.order', 'Добавить заказ'), 'url' => array('/order/orderBackend/create')),
);
?>
<div class="">
    <h1>
        <?php echo Yii::t('OrderModule.order', 'Заказы'); ?>
        <small><?php echo Yii::t('OrderModule.order', 'управление'); ?></small>
    </h1>
</div>


<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id' => 'order-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'rowCssClassExpression' => '$data->paid == Order::PAID_STATUS_PAID ? "alert-success" : ""',
        'columns' => array(
            array(
                'name' => 'id',
                'htmlOptions' => array('width' => '90px'),
                'type' => 'raw',
                'value' => 'CHtml::link("Заказ №".$data->id, array("/order/orderBackend/update", "id" => $data->id))',
            ),
            array(
                'name' => 'name',
                'type' => 'raw',
                'value' => '$data->name . ($data->note ? "<br><div class=\"note\">$data->note</div>" : "")',
                'htmlOptions' => array('width' => '400px'),
            ),
            'total_price',
            array(
                'name' => 'paid',
                'value' => '$data->getPaidStatus()',
                'filter' => $model->getPaidStatusList(),
            ),
            array(
                'name' => 'date'
            ),
            array(
                'name' => 'coupon_code',
            ),
            array(
                'name' => 'status',
                'type' => 'raw',
                'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("fire", "road", "ok", "trash"))',
                'filter' => $model->getStatusList()
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
