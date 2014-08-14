<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.type', 'Типы товаров') => array('/store/typeBackend/index'),
    Yii::t('StoreModule.type', 'Добавить'),
);

$this->pageTitle = Yii::t('StoreModule.type', 'Типы товаров - добавить');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.type', 'Управление'), 'url' => array('/store/typeBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.type', 'Добавить'), 'url' => array('/store/typeBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.type', 'Тип товара'); ?>
        <small><?php echo Yii::t('StoreModule.type', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'languages' => $languages, 'availableAttributes' => $availableAttributes)); ?>
