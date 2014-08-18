<?php
$this->breadcrumbs = array(
    Yii::t('DeliveryModule.delivery', 'Способы доставки') => array('/delivery/deliveryBackend/index'),
    Yii::t('DeliveryModule.delivery', 'Управление'),
);

$this->pageTitle = Yii::t('DeliveryModule.delivery', 'Способы доставки - управление');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('DeliveryModule.delivery', 'Управление способами доставка'), 'url' => array('/delivery/deliveryBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('DeliveryModule.delivery', 'Добавить способ доставки'), 'url' => array('/delivery/deliveryBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('DeliveryModule.delivery', 'Способы доставки'); ?>
        <small><?php echo Yii::t('DeliveryModule.delivery', 'управление'); ?></small>
    </h1>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id' => 'delivery-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'sortableRows' => true,
        'sortableAjaxSave' => true,
        'sortableAttribute' => 'position',
        'sortableAction' => '/delivery/deliveryBackend/sortable',
        'columns' => array(
            array(
                'name' => 'id',
                'htmlOptions' => array('width' => '50px'),
            ),
            array(
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/delivery/deliveryBackend/update", "id" => $data->id))',
            ),
            array(
                'name' => 'status',
                'type' => 'raw',
                'filter' => $model->getStatusList()
            ),
            'price',
            'free_from',
            'available_from',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
