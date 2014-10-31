<?php
Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/order-backend.css');

$this->breadcrumbs = array(
    Yii::t('OrderModule.order', 'Заказы') => array('/order/orderBackend/index'),
    Yii::t('OrderModule.order', 'Управление'),
);

$this->pageTitle = Yii::t('OrderModule.order', 'Заказы - управление');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('OrderModule.order', 'Управление заказами'), 'url' => array('/order/orderBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('OrderModule.order', 'Добавить заказ'), 'url' => array('/order/orderBackend/create')),
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
                'name' => 'date'
            ),
            array(
                'name' => 'name',
                'type' => 'raw',
                'value' => '$data->name . ($data->note ? "<br><div class=\"note\">$data->note</div>" : "")',
                'htmlOptions' => array('width' => '400px'),
            ),
            'total_price',
            array(
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/order/orderBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Order::STATUS_FINISHED => ['class' => 'label-success'],
                    Order::STATUS_ACCEPTED => ['class' => 'label-info'],
                    Order::STATUS_NEW => ['class' => 'label-default'],
                    Order::STATUS_DELETED => ['class' => 'label-danger'],
                ],
            ),
            array(
                'class'=> 'yupe\widgets\EditableStatusColumn',
                'name' => 'paid',
                'url'  => $this->createUrl('/order/orderBackend/inline'),
                'source'  => $model->getPaidStatusList(),
                'options' => [
                    Order::PAID_STATUS_NOT_PAID => ['class' => 'label-danger'],
                    Order::PAID_STATUS_PAID => ['class' => 'label-success']
                ],
            ),
            'payment_date',
            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
); ?>
