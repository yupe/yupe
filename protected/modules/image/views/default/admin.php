<?php
$this->breadcrumbs = array(
    $this->getModule('image')->getCategory() => array(''),
    Yii::t('image', 'Изображения') => array('admin'),
    Yii::t('image', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('image', 'Список изображений'), 'url' => array('index')),
    array('label' => Yii::t('image', 'Добавить изображение'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('image-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->module->getName();?></h1>

<?php $this->widget('YModuleInfo'); ?>

<?php echo CHtml::link(Yii::t('image', 'Поиск изображений'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
                                               'model' => $model,
                                          )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
                                                       'id' => 'image-grid',
                                                       'dataProvider' => $model->search(),
                                                       'columns' => array(
                                                           'id',
                                                           'parent_id',
                                                           array(
                                                               'name' => Yii::t('image', 'Изображение'),
                                                               'type' => 'raw',
                                                               'value' => 'CHtml::image($data->file,$data->alt,array("width" =>75, "height" => 75))'
                                                           ),
                                                           'name',
                                                           'creation_date',
                                                           array(
                                                               'name' => 'user_id',
                                                               'value' => '$data->user->getFullName()'
                                                           ),
                                                           'alt',
                                                           array(
                                                               'name' => 'type',
                                                               'value' => '$data->getType()'
                                                           ),
                                                           array(
                                                               'name' => 'status',
                                                               'value' => '$data->getStatus()'
                                                           ),
                                                           array(
                                                               'class' => 'CButtonColumn',
                                                           ),
                                                       ),
                                                  ));
                                                  ?>
