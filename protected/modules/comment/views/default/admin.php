<?php
$this->breadcrumbs = array(
    $this->getModule('category')->getCategory() => array(''),
    Yii::t('comment', 'Комментарии') => array('admin'),
    Yii::t('comment', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('comment', 'Добавить комментарий'), 'url' => array('create')),
    array('label' => Yii::t('comment', 'Список комментариев'), 'url' => array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('comment-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->module->getName();?></h1>

<?php $this->widget('YModuleInfo'); ?>

<?php echo CHtml::link(Yii::t('comment', 'Поиск комментариев'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
                                               'model' => $model,
                                          )); ?>
</div><!-- search-form -->

<?php $this->widget('YCustomGridView', array(
                                                       'id' => 'comment-grid',
                                                       'dataProvider' => $model->search(),
                                                       'columns' => array(
                                                           array(
                                                               'class'=>'CCheckBoxColumn',
                                                               'id'=>'itemsSelected',
                                                               'selectableRows' => '2',
                                                               'htmlOptions' => array(
                                                                   'class'=>'center',
                                                               ),
                                                           ),
                                                           'id',
                                                           'model',
                                                           'model_id',
                                                           array(
                                                               'name' => 'status',
                                                               'type' => 'raw',
                                                               'value' => '$this->grid->returnStatusHtml($data)'
                                                           ),
                                                           'text',
                                                           'creation_date',
                                                           'name',
                                                           'email',
                                                           array(
                                                               'class' => 'CButtonColumn',
                                                               'deleteConfirmation' => Yii::t('comment','Вы действительно хотите удалить выбранный комментарий?'),
                                                           ),
                                                       ),
                                                  )); ?>
