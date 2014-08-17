<?php
$this->breadcrumbs = array(
    Yii::t('OrderModule.order', 'Заказы') => array('/order/orderBackend/index'),
    Yii::t('OrderModule.order', 'Добавить'),
);

$this->pageTitle = Yii::t('OrderModule.order', 'Заказы - добавить');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('OrderModule.order', 'Управление заказами'), 'url' => array('/order/orderBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('OrderModule.order', 'Добавить заказ'), 'url' => array('/order/orderBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('OrderModule.order', 'Заказы'); ?>
        <small><?php echo Yii::t('OrderModule.order', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
