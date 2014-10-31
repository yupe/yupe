<?php
$this->breadcrumbs = array(
    Yii::t('DeliveryModule.delivery', 'Способы доставки') => array('/delivery/deliveryBackend/index'),
    Yii::t('DeliveryModule.delivery', 'Управление'),
);

$this->pageTitle = Yii::t('DeliveryModule.delivery', 'Способы доставки - управление');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('DeliveryModule.delivery', 'Управление способами доставка'), 'url' => array('/delivery/deliveryBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('DeliveryModule.delivery', 'Добавить способ доставки'), 'url' => array('/delivery/deliveryBackend/create')),
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
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/delivery/deliveryBackend/update", "id" => $data->id))',
            ),
            'price',
            'free_from',
            'available_from',
            array(
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/delivery/deliveryBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Delivery::STATUS_ACTIVE => ['class' => 'label-success'],
                    Delivery::STATUS_NOT_ACTIVE => ['class' => 'label-default'],
                ],
            ),
            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
); ?>
