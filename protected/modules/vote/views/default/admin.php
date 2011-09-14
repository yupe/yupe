<?php
$this->breadcrumbs = array(
    $this->getModule('vote')->getCategory() => array(''),
    Yii::t('vote', 'Голосование') => array('admin'),
    Yii::t('vote', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('vote', 'Список голосов'), 'url' => array('index')),
    array('label' => Yii::t('vote', 'Добавить голос'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('vote-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->module->getName();?></h1>

<?php $this->widget('ModuleInfoWidget'); ?>

<?php echo CHtml::link(Yii::t('vote', 'Поиск'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
                                               'model' => $model,
                                          )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
                                                       'id' => 'vote-grid',
                                                       'dataProvider' => $model->search(),
                                                       'columns' => array(
                                                           'id',
                                                           'model',
                                                           'modelId',
                                                           array(
                                                               'name' => 'userId',
                                                               'value' => '$data->user->nickName." (".$data->userId.")"'
                                                           ),
                                                           'creationDate',
                                                           'value',
                                                           array(
                                                               'class' => 'CButtonColumn',
                                                           ),
                                                       ),
                                                  )); ?>
