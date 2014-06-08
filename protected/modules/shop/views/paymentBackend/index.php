<script type="text/javascript">
    $(document).ready(function(){
        $("#payment-grid").find('tr').attr("style","cursor:move;");
    });
</script>

<?php
$this->breadcrumbs = array(
    Yii::t('ShopModule.payment', 'Способы оплаты') => array('/shop/paymentBackend/index'),
    Yii::t('ShopModule.payment', 'Управление'),
);

$this->pageTitle = Yii::t('ShopModule.payment', 'Способы оплаты - управление');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.payment', 'Управление способами оплаты'), 'url' => array('/shop/paymentBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.payment', 'Добавить способ оплаты'), 'url' => array('/shop/paymentBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.payment', 'Способы оплаты'); ?>
        <small><?php echo Yii::t('ShopModule.payment', 'управление'); ?></small>
    </h1>
</div>


<?php
$this->widget('yupe\widgets\CustomGridView', array(
    'id' => 'payment-grid',
    'type' => 'condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'sortableRows' => true,
    'sortableAjaxSave' => true,
    'sortableAttribute' => 'position',
    'sortableAction' => '/shop/paymentBackend/sortable',
    'columns' => array(
        array(
            'name' => 'id',
            'htmlOptions' => array('width' => '50px'),
        ),
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name, array("/shop/paymentBackend/update", "id" => $data->id))',
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("time", "ok-sign", "minus-sign"))',
            'filter' => $model->getStatusList()
        ),
        'module',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>
