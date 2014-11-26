<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Атрибуты') => ['/store/attributeBackend/index'],
    Yii::t('StoreModule.store', 'Добавить'),
];

$this->pageTitle = Yii::t('StoreModule.store', 'Атрибуты - добавить');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Управление'), 'url' => ['/store/attributeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Добавить'), 'url' => ['/store/attributeBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Атрибут'); ?>
        <small><?php echo Yii::t('StoreModule.store', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
