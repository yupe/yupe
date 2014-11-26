<?php
$this->breadcrumbs = [
    Yii::t('OrderModule.order', 'Заказы') => ['/order/orderBackend/index'],
    Yii::t('OrderModule.order', 'Добавить'),
];

$this->pageTitle = Yii::t('OrderModule.order', 'Заказы - добавить');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('OrderModule.order', 'Управление заказами'), 'url' => ['/order/orderBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('OrderModule.order', 'Добавить заказ'), 'url' => ['/order/orderBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('OrderModule.order', 'Заказы'); ?>
        <small><?php echo Yii::t('OrderModule.order', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
