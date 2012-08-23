<?php
$this->breadcrumbs = array(
    $this->getModule('contest')->getCategory() => array(''),
    Yii::t('contest', 'Конкурсы изображений') => array('admin'),
    Yii::t('contest', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('contest', 'Список конкурсов'), 'url' => array('index')),
    array('label' => Yii::t('contest', 'Добавить конкурс'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('contest-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->module->getName();?></h1>

<?php $this->widget('YModuleInfo'); ?>

<?php echo CHtml::link(Yii::t('contest', 'Поиск'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
                                               'model' => $model,
                                          )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
                                                       'id' => 'contest-grid',
                                                       'dataProvider' => $model->search(),
                                                       'columns' => array(
                                                           'id',
                                                           'name',
                                                           'description',
                                                           'start_add_image',
                                                           'stop_add_image',
                                                           'start_vote',
                                                           'stop_vote',
                                                           array(
                                                               'name' => 'status',
                                                               'value' => '$data->getStatus()'
                                                           ),
                                                           array(
                                                               'class' => 'CButtonColumn',
                                                           ),
                                                       ),
                                                  )); ?>
