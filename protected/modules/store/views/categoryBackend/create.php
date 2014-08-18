<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.category', 'Categories') => array('/store/categoryBackend/index'),
    Yii::t('StoreModule.category', 'Create'),
);

$this->pageTitle = Yii::t('StoreModule.category', 'Categories - create');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.category', 'Category manage'), 'url' => array('/store/categoryBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.category', 'Create category'), 'url' => array('/store/categoryBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.category', 'Category'); ?>
        <small><?php echo Yii::t('StoreModule.category', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
