<?php
$this->breadcrumbs = array(
    $this->getModule('news')->getCategory() => array(''),
    Yii::t('news', 'Новости') => array('admin'),
    Yii::t('news', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('news', 'Добавить новость'), 'url' => array('create')),
    array('label' => Yii::t('news', 'Список новостей'), 'url' => array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('news-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->module->getName();?></h1>

<?php $this->widget('ModuleInfoWidget'); ?>

<?php echo CHtml::link(Yii::t('news', 'Поиск новостей'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
                                               'model' => $model,
                                          )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
                                                       'id' => 'news-grid',
                                                       'dataProvider' => $model->search(),
                                                       'columns' => array(
                                                           'id',
                                                           array(
                                                               'name' => 'title',
                                                               'type' => 'raw',
                                                               'value' => 'CHtml::link($data->title,array("/news/default/update","id" => $data->id))'
                                                           ),
                                                           'date',
                                                           'alias',
                                                           array(
                                                               'name' => 'status',
                                                               'value' => '$data->getStatus()'
                                                           ),
                                                           'creationDate',
                                                           'changeDate',
                                                           array(
                                                               'class' => 'CButtonColumn',
                                                           ),
                                                       ),
                                                  )); ?>
