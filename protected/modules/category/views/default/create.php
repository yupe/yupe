<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('category')->getCategory() => array(),
        Yii::t('CategoryModule.category', 'Категории') => array('/category/default/index'),
        Yii::t('CategoryModule.category', 'Добавление'),
    );

    $this->pageTitle = Yii::t('CategoryModule.category', 'Категория - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CategoryModule.category', 'Управление категориями'), 'url' => array('/category/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CategoryModule.category', 'Добавить категорию'), 'url' => array('/category/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CategoryModule.category', 'Категория'); ?>
        <small><?php echo Yii::t('CategoryModule.category', 'добавление'); ?></small>
    </h1>
</div>

<?php echo  $this->renderPartial('_form', array('model' => $model, 'languages' => $languages)); ?>