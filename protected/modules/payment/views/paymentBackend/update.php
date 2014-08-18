<?php
$this->breadcrumbs = array(
    Yii::t('PaymentModule.payment', 'Способы оплаты') => array('/payment/paymentBackend/index'),
    $model->name => array('/payment/paymentBackend/view', 'id' => $model->id),
    Yii::t('PaymentModule.payment', 'Редактирование'),
);

$this->pageTitle = Yii::t('PaymentModule.payment', 'Способы оплаты - редактирование');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('PaymentModule.payment', 'Управление способами оплаты'), 'url' => array('/payment/paymentBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('PaymentModule.payment', 'Добавить способ оплаты'), 'url' => array('/payment/paymentBackend/create')),
    array('label' => Yii::t('PaymentModule.payment', 'Способ оплаты') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon' => 'glyphicon glyphicon-pencil',
        'label' => Yii::t('PaymentModule.payment', 'Редактирование способ оплаты'),
        'url' => array(
            '/payment/paymentBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-trash',
        'label' => Yii::t('PaymentModule.payment', 'Удалить способ оплаты'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/payment/paymentBackend/delete', 'id' => $model->id),
            'confirm' => Yii::t('PaymentModule.payment', 'Вы уверены, что хотите удалить способ оплаты?'),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PaymentModule.payment', 'Редактирование') . ' ' . Yii::t('PaymentModule.payment', 'способа оплаты'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
