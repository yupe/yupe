<?php
$mainAssets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.shop.views.assets'), false, -1, YII_DEBUG);

$this->breadcrumbs = array(
    Yii::t('ShopModule.order', 'Заказы') => array('/shop/orderBackend/index'),
    Yii::t('ShopModule.order', 'Управление'),
);

$this->pageTitle = Yii::t('ShopModule.order', 'Заказы - управление');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.order', 'Управление заказами'), 'url' => array('/shop/orderBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.order', 'Добавить заказ'), 'url' => array('/shop/orderBackend/create')),
);
?>
<div class="">
    <h1>
        <?php echo Yii::t('ShopModule.order', 'Заказы'); ?>
        <small><?php echo Yii::t('ShopModule.order', 'управление'); ?></small>
    </h1>
</div>


<?php
$this->widget('yupe\widgets\CustomGridView', array(
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
            'value' => 'CHtml::link("Заказ №".$data->id, array("/shop/orderBackend/update", "id" => $data->id))',
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
            'name' => 'status',
            'type' => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("fire", "road", "ok", "trash"))',
            'filter' => $model->getStatusList()
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>
