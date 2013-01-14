<?php
	$category = Yii::app()->getModule('category');
    $this->breadcrumbs = array(
    	$category->getCategory() => array('/yupe/backend/index', 'category' => $category->getCategoryType() ),
        Yii::t('CategoryModule.category', 'Категории') => array('/category/defaultAdmin/index'),
        Yii::t('CategoryModule.category', 'Добавление'),
    );

    $this->pageTitle = Yii::t('CategoryModule.category', 'Категория - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CategoryModule.category', 'Управление категориями'), 'url' => array('/category/defaultAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CategoryModule.category', 'Добавить категорию'), 'url' => array('/category/defaultAdmin/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CategoryModule.category', 'Категория'); ?>
        <small><?php echo Yii::t('CategoryModule.category', 'добавление'); ?></small>
    </h1>
</div>

<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>