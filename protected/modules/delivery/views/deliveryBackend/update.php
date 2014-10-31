<?php
$this->breadcrumbs = array(
    Yii::t('DeliveryModule.delivery', 'Способы доставки') => array('/delivery/deliveryBackend/index'),
    $model->name => array('/delivery/deliveryBackend/view', 'id' => $model->id),
    Yii::t('DeliveryModule.delivery', 'Редактирование'),
);

$this->pageTitle = Yii::t('DeliveryModule.delivery', 'Способы доставки - редактирование');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('DeliveryModule.delivery', 'Управление способами доставки'), 'url' => array('/delivery/deliveryBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('DeliveryModule.delivery', 'Добавить способ доставки'), 'url' => array('/delivery/deliveryBackend/create')),
    array('label' => Yii::t('DeliveryModule.delivery', 'Способ доставки') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('DeliveryModule.delivery', 'Редактирование способ доставки'),
        'url' => array(
            '/delivery/deliveryBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('DeliveryModule.delivery', 'Удалить способ доставки'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/delivery/deliveryBackend/delete', 'id' => $model->id),
            'confirm' => Yii::t('DeliveryModule.delivery', 'Вы уверены, что хотите удалить способ доставки?'),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('DeliveryModule.delivery', 'Редактирование') . ' ' . Yii::t('DeliveryModule.delivery', 'способа доставки'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo $this->renderPartial('_form', array('model' => $model, 'payments' => $payments)); ?>