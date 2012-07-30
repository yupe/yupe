<?php
    $this->pageTitle = Yii::t('user', 'Управление страницами');
    $this->breadcrumbs = array(
        $this->getModule('page')->getCategory() => array(''),
        Yii::t('page', 'Страницы') => array('admin'),
        Yii::t('page', 'Управление'),
    );

$this->menu = array(
        array('icon'=> 'list-alt white', 'label' => Yii::t('page', 'Управление страницами'), 'url' => array('/page/default/admin')),
        array('icon'=> 'file', 'label' => Yii::t('page', 'Добавить страницу'), 'url' => array('/page/default/create')),
    );
?>
<div class="page-header"><h1><?=$this->module->getName()?> <small>управление</small></h1></div>
<button class="btn btn-small dropdown-toggle"
    data-toggle="collapse"
    data-target="#search-toggle" >
    <i class="icon-search"></i>
    <?=CHtml::link(Yii::t('page', 'Поиск страниц'), '#', array('class' => 'search-button',))?>
    <span class="caret"></span>
</button>

    <div id="search-toggle" class="collapse <?=isset($_GET[get_class($model)])?'in':'out'; ?>">
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
    /** @var CActiveDataProvider $dp */
    $dp = $model->search();
    $dp->criteria->addCondition('lang="'.Yii::app()->language.'" OR lang IS NULL');
    $this->widget('YCustomGridView', array(
        'itemsCssClass' => ' table table-condensed',
        'id'=>'page-grid',
        'sortField' => 'menu_order',
        'dataProvider'=> $dp,
        'columns'=>array(
            'id',
            'lang',
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
                'name'  => 'menu_order',
                'type'  => 'raw',
                'value' => '$this->grid->getUpDownButtons($data)'
            ),
            array(
                'name' => 'status',
                'type' => 'raw',
                'value' => '$this->grid->returnBootstrapStatusHtml($data)',
                'htmlOptions' => array('style'=>'width:40px; text-align:center;'),
            ),
             array(
                'class'=>'bootstrap.widgets.BootButtonColumn',
                'htmlOptions'=>array('style'=>'width: 50px'),
		'buttons'=> array(
			'update'=> array('url'=> 'array("/page/default/update/","slug"=>$data->slug)'),

		),
            ),
        ),
    ));
?>