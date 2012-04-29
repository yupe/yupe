<?php
    $this->pageTitle = Yii::t('user', 'Управление страницами');
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
        $('.search-button').click(function() {
        	$('.search-form').toggle();
        	return false;
        });
        $('.search-form form').submit(function() {
        	$.fn.yiiGridView.update('page-grid', {
        		data: $(this).serialize()
        	});
        	return false;
        });
    ");
?>

<h1><?=$this->module->getName()?></h1>

<?php $this->widget('YModuleInfo'); ?>

<?=CHtml::link(Yii::t('page', 'Поиск страниц'), '#', array('class' => 'search-button'))?>

<div class="search-form" style="display:none">
    <?php
        $this->renderPartial('_search', array(
           'model' => $model,
           'pages' => $pages
        ));
    ?>
</div><!-- search-form -->

<?php
    $this->widget('bootstrap.widgets.BootGridView', array(
        'type'=>'striped bordered condensed',
        'id'=>'page-grid',
        'dataProvider'=>$model->search(),
        'columns'=>array(
            'id',
             array(
                'name'=>'name',
                'type'=>'raw',
                'value'=>'CHtml::link($data->name,array("/page/default/update","id" => $data->id))'
             ),
             array(
                'name'=>'parent_Id',
                'value'=>'$data->parent_Id ? page::model()->findByPk($data->parent_Id)->name : Yii::t("page","нет")'
             ),
             'title',
             array(
                'name'=>'status',
                'value'=>'$data->getStatus()',
             ),
             array(
                'name'=>'creation_date',
                'value'=>'Yii::app()->dateFormatter->formatDateTime($data->creation_date, "short")',
             ),
             array(
                'name'=>'change_date',
                'value'=>'Yii::app()->dateFormatter->formatDateTime($data->creation_date, "short")',
             ),
             array(
                'name'=>'user_id',
                'value'=>'$data->author->getFullName()'
             ),
             array(
                'name'=>'change_user_id',
                'value'=>'$data->changeAuthor->getFullName()'
             ),
             array(
                'class'=>'bootstrap.widgets.BootButtonColumn',
                'htmlOptions'=>array('style'=>'width: 50px'),
            ),
        ),
    ));
?>