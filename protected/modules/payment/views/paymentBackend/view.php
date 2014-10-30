<?php
/* @var $model Payment */
$this->breadcrumbs = array(
    Yii::t('PaymentModule.payment', 'Способы оплаты') => array('/payment/paymentBackend/index'),
    $model->name,
);

$this->pageTitle = Yii::t('PaymentModule.payment', 'Способы оплаты - просмотр');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('PaymentModule.payment', 'Управление способами оплаты'), 'url' => array('/payment/paymentBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('PaymentModule.payment', 'Добавить способ оплаты'), 'url' => array('/payment/paymentBackend/create')),
    array('label' => Yii::t('PaymentModule.payment', 'Способ оплаты') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('PaymentModule.payment', 'Редактирование способ оплаты'),
        'url' => array(
            '/payment/paymentBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('PaymentModule.payment', 'Просмотреть способ оплаты'),
        'url' => array(
            '/payment/paymentBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-trash-o',
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
        <?php echo Yii::t('PaymentModule.payment', 'Просмотр') . ' ' . Yii::t('PaymentModule.payment', 'способа оплаты'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data' => $model,
        'attributes' => array(
            'id',
            'name',
            array(
                'name' => 'status',
                'value' => $model->statusTitle,
            ),
            'module',
            'position',
            array(
                'name' => 'description',
                'type' => 'html'
            ),

        ),
    )
); ?>
