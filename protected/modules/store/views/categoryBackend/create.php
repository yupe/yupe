<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.store', 'Categories') => array('/store/categoryBackend/index'),
    Yii::t('StoreModule.store', 'Create'),
);

$this->pageTitle = Yii::t('StoreModule.store', 'Categories - create');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Category manage'), 'url' => array('/store/categoryBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Create category'), 'url' => array('/store/categoryBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Category'); ?>
        <small><?php echo Yii::t('StoreModule.store', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
