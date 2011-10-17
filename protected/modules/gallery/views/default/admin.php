<?php
$this->breadcrumbs = array(
    $this->getModule('category')->getCategory() => array(''),
    Yii::t('gallery', 'Галереи изображений') => array('admin'),
    Yii::t('gallery', 'Управление галереями'),
);

$this->menu = array(
    array('label' => Yii::t('gallery', 'Список галерей'), 'url' => array('index')),
    array('label' => Yii::t('gallery', 'Добавить галерею'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('gallery-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->module->getName();?></h1>

<?php $this->widget('YModuleInfo'); ?>

<?php echo CHtml::link(Yii::t('gallery', 'Поиск'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
                                               'model' => $model,
                                          )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
                                                       'id' => 'gallery-grid',
                                                       'dataProvider' => $model->search(),
                                                       'columns' => array(
                                                           'id',
                                                           'name',
                                                           array(
                                                               'name' => Yii::t('gallery', 'Количество фото'),
                                                               'value' => '$data->imagesCount'
                                                           ),
                                                           'description',
                                                           array(
                                                               'name' => 'status',
                                                               'value' => '$data->getStatus()'
                                                           ),
                                                           array(
                                                               'class' => 'CButtonColumn',
                                                           ),
                                                       ),
                                                  )); ?>
