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
$('#Page_parent_Id').val('');
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

<?php $this->widget('YModuleInfo'); ?>

<?php echo CHtml::link(Yii::t('page', 'Поиск страниц'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
                                               'model' => $model,
                                               'pages' => $pages
                                          ));
    ?>
</div><!-- search-form -->

<?php

$this->widget('YCustomGridView', array(
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
                                                         'name' => 'parent_Id',
                                                         'value' => '$data->parent_Id ? page::model()->findByPk($data->parent_Id)->name : Yii::t("page","нет")'
                                                     ),
                                                     'title',
                                                     array(
                                                         'name' => 'status',
                                                         'type' => 'raw',
                                                         'value' => '$this->grid->returnStatusHtml($data)'
                                                     ),
                                                     'creation_date',
                                                     'change_date',
                                                     array(
                                                         'name' => 'user_id',
                                                         'value' => '$data->author->getFullName()'
                                                     ),
                                                     array(
                                                         'name' => 'change_user_id',
                                                         'value' => '$data->changeAuthor->getFullName()'
                                                     ),
                                                     array(
                                                         'class'    => 'CButtonColumn',
                                                         'template' => '{view}{update}{delete}{liveview}',
                                                         'buttons'  => array(
                                                             'liveview' => array(
                                                                 'label' => Yii::t('page','Посмотреть на сайте'),
                                                                 'url'   => 'Yii::app()->createUrl("/page/page/show/",array("slug" => $data->slug,"preview" => 1))',
                                                                 'imageUrl' => Yii::app()->baseUrl.'/web/images/www.png'
                                                             )
                                                         )
                                                     ),

                                                 ),
                                            )); ?>
