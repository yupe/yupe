<?php
    $this->pageTitle = Yii::t('user', 'Управление страницами');
    $this->breadcrumbs = array(
        $this->getModule('page')->getCategory() => array(''),
        Yii::t('page', 'Страницы') => array('admin'),
        Yii::t('page', 'Управление'),
    );

$this->menu = array(
        array('encodeLabel'=> false, 'label' => '<i class="icon-list icon-white"></i>'.Yii::t('page', 'Управление страницами'), 'url' => array('/page/default/admin')),
        array('encodeLabel'=> false, 'label' => '<i class="icon-file"></i>'.Yii::t('page', 'Добавить страницу'), 'url' => array('/page/default/create')),
    );
?>
<div class="page-header"><h1><?=$this->module->getName()?> <small>Управление</small></h1></div>
<button class="btn btn-small dropdown-toggle"
    data-toggle="collapse"
    data-target="#search-toggle" >
    <?=CHtml::link(Yii::t('page', 'Поиск страниц'), '#', array('class' => 'search-button'))?>
    <span class="caret"></span>
</button>

    <div id="search-toggle" class="collapse out">
    <?php
    Yii::app()->clientScript->registerScript('search', "
            $('#Page_parent_Id').val('');
            $('#Page_status').val('');
            $('.search-form form').submit(function() {
                $.fn.yiiGridView.update('page-grid', {
                    data: $(this).serialize()
                });
                return false;
            });
        ");
    ?>
            <?php
            $this->renderPartial('_search', array(
                'model' => $model,
                'pages' => $pages
            ));
            ?>

    </div>


<?php
    $dp = $model->search();
    $dp->sort->defaultOrder = 'parent_Id ASC, menu_order DESC';
    $this->widget('YCustomGridView', array(
        'itemsCssClass' => ' table table-condensed',
        'id'=>'page-grid',
        'dataProvider'=> $dp,
        'columns'=>array(
            'id',
            array(
                'name' => 'status',
                'type' => 'raw',
                'value' => '$this->grid->returnBootstrapStatusHtml($data)',
                'htmlOptions' => array('style'=>'width:40px; text-align:center;'),
            ),

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
                'name'=>'user_id',
                'value'=>'$data->author->getFullName()'
             ),
             array(
                'class'=>'bootstrap.widgets.BootButtonColumn',
                'htmlOptions'=>array('style'=>'width: 50px'),
            ),
        ),
    ));
?>