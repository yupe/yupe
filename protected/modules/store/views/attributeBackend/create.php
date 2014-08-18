<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.attribute', 'Атрибуты') => array('/store/attributeBackend/index'),
    Yii::t('StoreModule.attribute', 'Добавить'),
);

$this->pageTitle = Yii::t('StoreModule.attribute', 'Атрибуты - добавить');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.attribute', 'Управление'), 'url' => array('/store/attributeBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.attribute', 'Добавить'), 'url' => array('/store/attributeBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.attribute', 'Атрибут'); ?>
        <small><?php echo Yii::t('StoreModule.attribute', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
