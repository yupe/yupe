<?php
$this->breadcrumbs = array(
    $this->getModule('contentblock')->getCategory() => array(''),
    Yii::t('contentblock', 'Блоки контента') => array('admin'),
    Yii::t('contentblock', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('contentblock', 'Добавить новый блок'), 'url' => array('create')),
    array('label' => Yii::t('contentblock', 'Список блоков'), 'url' => array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('content-block-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->module->getName();?></h1>

<?php $this->widget('YModuleInfo'); ?>


<?php echo CHtml::link(Yii::t('contentblock', 'Поиск'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
                                               'model' => $model,
                                          )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
                                                       'id' => 'content-block-grid',
                                                       'dataProvider' => $model->search(),
                                                       'columns' => array(
                                                           'id',
                                                           array(
                                                               'name' => 'name',
                                                               'type' => 'raw',
                                                               'value' => 'CHtml::link($data->name,array("/contentblock/default/update","id" => $data->id))'
                                                           ),
                                                           array(
                                                               'name' => 'type',
                                                               'value' => '$data->getType()'
                                                           ),
                                                           'code',                                                           
                                                           'description',
                                                           array(
                                                               'class' => 'CButtonColumn',
                                                           ),
                                                       ),
                                                  )); ?>
