<?php
$this->breadcrumbs = array(
    $this->getModule('category')->getCategory() => array(''),
    Yii::t('category', 'Категории') => array('admin'),
    Yii::t('category', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('category', 'Добавить категорию'), 'url' => array('create')),
    array('label' => Yii::t('category', 'Список категорий'), 'url' => array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('category-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->module->getName();?></h1>

<?php $this->widget('YModuleInfo'); ?>

<?php echo CHtml::link(Yii::t('category', 'Поиск категорий'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
                                               'model' => $model,
                                          )); ?>
</div><!-- search-form -->

<?php $this->widget('YCustomGridView', array(
                                                       'id' => 'category-grid',
                                                       'dataProvider' => $model->search(),
                                                       'columns' => array(
                                                           'id',
                                                           array(
                                                               'name' => 'name',
                                                               'type' => 'raw',
                                                               'value' => 'CHtml::link($data->name,array("/category/default/update","id" => $data->id))'
                                                           ),
                                                           'description',
                                                           'alias',
                                                           array(
                                                               'name' => 'status',
                                                               'type' => 'raw',
                                                               'value' => '$this->grid->returnStatusHtml($data)'
                                                           ),
                                                           array(
                                                               'class' => 'CButtonColumn',
                                                           ),
                                                       ),
                                                  )); ?>
