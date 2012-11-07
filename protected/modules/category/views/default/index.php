<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array(''),
    Yii::t('category','Категории') => array( 'index' ),
    Yii::t('category', 'Управление'),
);
$this->pageTitle = Yii::t('category','Категории управление');
$this->menu = array(
    array( 'icon'  => 'list-alt white', 'label' => Yii::t('category', 'Управление категориями'), 'url'   => array( '/category/default/index' ) ),
    array( 'icon'  => 'plus-sign', 'label' => Yii::t('category', 'Добавить категорию'), 'url'   => array( '/category/default/create' ) ),
);
?>
<div class="page-header">
    <h1><?php echo ucfirst(Yii::t('category', 'Категории')); ?>    <small><?php echo Yii::t('category', 'управление'); ?></small>
    </h1>
</div>
<button class="btn btn-small dropdown-toggle"  data-toggle="collapse"  data-target="#search-toggle" >
    <i class="icon-search"></i>
    <a class="search-button" href="#"><?php echo Yii::t('category','Поиск категорий');?></a>    <span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form').submit(function() {
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

<p>
    <?php echo Yii::t('category', 'В данном разделе представлены средства управления категориями'); ?>
</p>

<?php
$this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'category-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
         array(
            'name'  => 'name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->name, array("/category/default/update/", "alias" => $data->alias))',
        ),
        'alias',
        array(
            'name'  => 'parent_id',
            'value' => '$data->getParentName()',
        ),
        array(
            'name'  => 'image',
            'type'  => 'raw',
            'value' => '$data->image ? CHtml::image($data->imageSrc, $data->name, array("width"  => 100, "height" => 100)) : "---"',
        ),
        'lang',
        array(
            'name'  => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status")',
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>
