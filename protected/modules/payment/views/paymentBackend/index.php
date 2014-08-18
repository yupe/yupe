<?php
$this->breadcrumbs = array(
    Yii::t('PaymentModule.payment', 'Способы оплаты') => array('/payment/paymentBackend/index'),
    Yii::t('PaymentModule.payment', 'Управление'),
);

$this->pageTitle = Yii::t('PaymentModule.payment', 'Способы оплаты - управление');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('PaymentModule.payment', 'Управление способами оплаты'), 'url' => array('/payment/paymentBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('PaymentModule.payment', 'Добавить способ оплаты'), 'url' => array('/payment/paymentBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PaymentModule.payment', 'Способы оплаты'); ?>
        <small><?php echo Yii::t('PaymentModule.payment', 'управление'); ?></small>
    </h1>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id' => 'payment-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'sortableRows' => true,
        'sortableAjaxSave' => true,
        'sortableAttribute' => 'position',
        'sortableAction' => '/payment/paymentBackend/sortable',
        'columns' => array(
            array(
                'name' => 'id',
                'htmlOptions' => array('width' => '50px'),
            ),
            array(
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/payment/paymentBackend/update", "id" => $data->id))',
            ),
            array(
                'name' => 'status',
                'type' => 'raw',
                'filter' => $model->getStatusList()
            ),
            'module',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
