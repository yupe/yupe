<?php $this->pageTitle = Yii::t('user', 'Управление страницами'); ?>

<?php
$this->breadcrumbs = array(
    $this->getModule('page')->getCategory() => array(''),
    Yii::t('page', 'Страницы') => array('admin'),
    Yii::t('page', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('page', 'Добавить страницу'), 'url' => array('create')),
);


Yii::app()->clientScript->registerScript('search', "
$('#Page_parentId').val('');
$('#Page_status').val('');
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('page-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->module->getName();?></h1>

<?php $this->widget('ModuleInfoWidget'); ?>

<?php echo CHtml::link(Yii::t('page', 'Поиск страниц'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
                                               'model' => $model,
                                               'pages' => $pages
                                          ));
    ?>
</div><!-- search-form -->

<?php

$this->widget('zii.widgets.grid.CGridView', array(
                                                 'id' => 'page-grid',
                                                 'dataProvider' => $model->search(),
                                                 'columns' => array(
                                                     'id',
                                                     array(
                                                         'name' => 'name',
                                                         'type' => 'raw',
                                                         'value' => 'CHtml::link($data->name,array("/page/default/update","id" => $data->id))'
                                                     ),
                                                     array(
                                                         'name' => 'parentId',
                                                         'value' => '$data->parentId ? page::model()->findByPk($data->parentId)->name : Yii::t("page","нет")'
                                                     ),
                                                     'title',
                                                     array(
                                                         'name' => 'status',
                                                         'value' => '$data->getStatus()',
                                                     ),
                                                     'creationDate',
                                                     'changeDate',
                                                     array(
                                                         'name' => 'userId',
                                                         'value' => '$data->author->getFullName()'
                                                     ),
                                                     array(
                                                         'name' => 'changeUserId',
                                                         'value' => '$data->changeAuthor->getFullName()'
                                                     ),
                                                     array(
                                                         'class' => 'CButtonColumn',
                                                     ),

                                                 ),
                                            )); ?>
