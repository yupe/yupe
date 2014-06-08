<script type="text/javascript">
    $(document).ready(function(){
        $("#delivery-grid").find('tr').attr("style","cursor:move;");
    });
</script>

<?php
$this->breadcrumbs = array(
    Yii::t('ShopModule.delivery', 'Способы доставки') => array('/shop/deliveryBackend/index'),
    Yii::t('ShopModule.delivery', 'Управление'),
);

$this->pageTitle = Yii::t('ShopModule.delivery', 'Способы доставки - управление');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.delivery', 'Управление способами доставка'), 'url' => array('/shop/deliveryBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.delivery', 'Добавить способ доставки'), 'url' => array('/shop/deliveryBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.delivery', 'Способы доставки'); ?>
        <small><?php echo Yii::t('ShopModule.delivery', 'управление'); ?></small>
    </h1>
</div>


<?php
$this->widget('yupe\widgets\CustomGridView', array(
    'id' => 'delivery-grid',
    'type' => 'condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'sortableRows' => true,
    'sortableAjaxSave' => true,
    'sortableAttribute' => 'position',
    'sortableAction' => '/shop/deliveryBackend/sortable',
    'columns' => array(
        array(
            'name' => 'id',
            'htmlOptions' => array('width' => '50px'),
        ),
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name, array("/shop/deliveryBackend/update", "id" => $data->id))',
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("time", "ok-sign", "minus-sign"))',
            'filter' => $model->getStatusList()
        ),
        'price',
        'free_from',
        'available_from',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>
