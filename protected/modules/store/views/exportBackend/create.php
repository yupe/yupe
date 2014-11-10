<?php
/* @var $model Export */

$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Экспорт товаров') => ['/store/exportBackend/index'],
    Yii::t('StoreModule.store', 'Добавить'),
];

$this->pageTitle = Yii::t('StoreModule.store', 'Выгрузка товаров - добавить');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Управление'), 'url' => ['/store/exportBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Добавить'), 'url' => ['/store/exportBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Выгрузка'); ?>
        <small><?php echo Yii::t('StoreModule.store', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
