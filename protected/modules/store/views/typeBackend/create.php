<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.type', 'Типы товаров') => ['/store/typeBackend/index'],
    Yii::t('StoreModule.type', 'Добавить'),
];

$this->pageTitle = Yii::t('StoreModule.type', 'Типы товаров - добавить');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.type', 'Управление'), 'url' => ['/store/typeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.type', 'Добавить'), 'url' => ['/store/typeBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.type', 'Тип товара'); ?>
        <small><?php echo Yii::t('StoreModule.type', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model, 'availableAttributes' => $availableAttributes]); ?>
