<?php
$this->breadcrumbs = array(
    'категории' => array( 'index' ),
    Yii::t('yupe', 'Управление'),
);
$this->pageTitle = "категории - " . "Yii::t('yupe','управление')";
$this->menu = array(
    array( 'icon'  => 'list-alt white', 'label' => Yii::t('yupe', 'Управление категориями'), 'url'   => array( '/category/default/index' ) ),
    array( 'icon'  => 'file', 'label' => Yii::t('yupe', 'Добавить категорию'), 'url'   => array( '/category/default/create' ) ),
);
?>
<div class="page-header">
    <h1><?php echo ucfirst(Yii::t('yupe', 'категории')); ?>    <small><?php echo Yii::t('yupe', 'управление'); ?></small>
    </h1>
</div>
<button class="btn btn-small dropdown-toggle"  data-toggle="collapse"  data-target="#search-toggle" >
    <i class="icon-search"></i>
    <a class="search-button" href="#">Поиск категорий</a>    <span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
    <?php
    Yii::app()->clientScript->registerScript('search', "
        $('.search-form form').submit(function() {
            $.fn.yiiGridView.update('category-grid', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<br/>

<p><?php echo Yii::t('yupe', 'В данном разделе представлены средства управления'); ?> <?php echo Yii::t('yupe', 'категориями'); ?>.</p>


<?php
$dp = $model->search();
$this->widget('bootstrap.widgets.TbGridView', array(
    'id'    => 'category-grid',
    'type'  => 'condensed ',
    'pager' => array( 'class'=> 'bootstrap.widgets.TbPager', 'prevPageLabel' => "←", 'nextPageLabel' => "→" ),
    'dataProvider'  => $dp,
    'filter'        => $model,
    'columns'       => array(
        'id',
        array(
            'name'  => 'parent_id',
            'value' => '$data->getParentName()',
        ),
        'name',
        'alias',
        array(
            'name'  => 'image',
            'type'  => 'raw',
            'value' => '$data->image ? CHtml::image(Yii::app()->baseUrl . "/" . Yii::app()->getModule("yupe")->uploadPath . DIRECTORY_SEPARATOR . Yii::app()->getModule("category")->uploadPath . DIRECTORY_SEPARATOR . $data->image, $data->name, array( "width"  => 100, "height" => 100 )) : "---"',
        ),
        array(
            'name'  => 'status',
            'value' => '$data->getStatus()',
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>
