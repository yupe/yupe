<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.producer', 'Производители') => ['/store/producerBackend/index'],
    Yii::t('StoreModule.producer', 'Добавить'),
];

$this->pageTitle = Yii::t('StoreModule.producer', 'Производители - добавить');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.producer', 'Управление производителями'), 'url' => ['/store/producerBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.producer', 'Добавить производителя'), 'url' => ['/store/producerBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.producer', 'Производители'); ?>
        <small><?php echo Yii::t('StoreModule.producer', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
