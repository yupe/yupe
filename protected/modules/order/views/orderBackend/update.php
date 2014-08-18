<?php
$this->breadcrumbs = array(
    Yii::t('OrderModule.order', 'Заказы') => array('/order/orderBackend/index'),
    Yii::t('OrderModule.order', 'Заказ №' . $model->id) => array('/order/orderBackend/view', 'id' => $model->id),
    Yii::t('OrderModule.order', 'Редактирование'),
);

$this->pageTitle = Yii::t('OrderModule.order', 'Заказы - редактирование');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('OrderModule.order', 'Управление заказами'), 'url' => array('/order/orderBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('OrderModule.order', 'Добавить заказ'), 'url' => array('/order/orderBackend/create')),
    array('label' => Yii::t('OrderModule.order', 'Заказ') . ' «' . $model->id . '»'),
    array(
        'icon' => 'glyphicon glyphicon-pencil',
        'label' => Yii::t('OrderModule.order', 'Редактирование заказа'),
        'url' => array(
            '/order/orderBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-eye-open',
        'label' => Yii::t('OrderModule.order', 'Просмотреть заказ'),
        'url' => array(
            '/order/orderBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-trash',
        'label' => Yii::t('OrderModule.order', 'Удалить заказ'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/order/orderBackend/delete', 'id' => $model->id),
            'confirm' => Yii::t('OrderModule.order', 'Вы уверены, что хотите удалить заказ?'),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('OrderModule.order', 'Редактирование') . ' ' . Yii::t('OrderModule.order', 'заказа'); ?>
        <small>&laquo;№<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
