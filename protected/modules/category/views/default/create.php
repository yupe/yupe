<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('category')->getCategory() => array(),
        Yii::t('CategoryModule.category', 'Categories') => array('/category/default/index'),
        Yii::t('CategoryModule.category', 'Create'),
    );

    $this->pageTitle = Yii::t('CategoryModule.category', 'Categories - create');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CategoryModule.category', 'Category manage'), 'url' => array('/category/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CategoryModule.category', 'Create category'), 'url' => array('/category/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CategoryModule.category', 'Category'); ?>
        <small><?php echo Yii::t('CategoryModule.category', 'create'); ?></small>
    </h1>
</div>

<?php echo  $this->renderPartial('_form', array('model' => $model, 'languages' => $languages)); ?>