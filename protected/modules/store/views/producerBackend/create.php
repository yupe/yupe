<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.producer', 'Производители') => array('/store/producerBackend/index'),
    Yii::t('StoreModule.producer', 'Добавить'),
);

$this->pageTitle = Yii::t('StoreModule.producer', 'Производители - добавить');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.producer', 'Управление производителями'), 'url' => array('/store/producerBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.producer', 'Добавить производителя'), 'url' => array('/store/producerBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.producer', 'Производители'); ?>
        <small><?php echo Yii::t('StoreModule.producer', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
