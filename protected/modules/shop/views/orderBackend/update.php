<?php
$this->breadcrumbs = array(
    Yii::t('ShopModule.order', 'Заказы') => array('/shop/orderBackend/index'),
    Yii::t('ShopModule.order', 'Заказ №' . $model->id) => array('/shop/orderBackend/view', 'id' => $model->id),
    Yii::t('ShopModule.order', 'Редактирование'),
);

$this->pageTitle = Yii::t('ShopModule.order', 'Заказы - редактирование');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.order', 'Управление заказами'), 'url' => array('/shop/orderBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.order', 'Добавить заказ'), 'url' => array('/shop/orderBackend/create')),
    array('label' => Yii::t('ShopModule.order', 'Заказ') . ' «' . $model->id . '»'),
    array('icon' => 'pencil', 'label' => Yii::t('ShopModule.order', 'Редактирование заказа'), 'url' => array(
        '/shop/orderBackend/update',
        'id' => $model->id
    )),
    array('icon' => 'trash', 'label' => Yii::t('ShopModule.order', 'Удалить заказ'), 'url' => '#', 'linkOptions' => array(
        'submit' => array('/shop/orderBackend/delete', 'id' => $model->id),
        'confirm' => Yii::t('ShopModule.order', 'Вы уверены, что хотите удалить заказ?'),
        'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
        'csrf' => true,
    )),
);
?>
    <div class="page-header">
        <h1>
            <?php echo Yii::t('ShopModule.order', 'Редактирование') . ' ' . Yii::t('ShopModule.order', 'заказа'); ?>
            <small>&laquo;№<?php echo $model->id; ?>&raquo;</small>
        </h1>
    </div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>