<?php
	$category = Yii::app()->getModule('category');
    $this->breadcrumbs = array(
        $category->getCategory() => array('/yupe/backend/index', 'category' => $category->getCategoryType() ),
        Yii::t('CategoryModule.category', 'Категории'),
    );

    $this->pageTitle = Yii::t('CategoryModule.category', 'Категории - управление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CategoryModule.category', 'Управление категориями'), 'url' => array('/category/defaultAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CategoryModule.category', 'Добавить категорию'), 'url' => array('/category/defaultAdmin/create'))
    );
   
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CategoryModule.category', 'Категории'); ?>
        <small><?php echo Yii::t('CategoryModule.category', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('CategoryModule.category', 'Поиск категорий'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
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

<p><?php echo Yii::t('CategoryModule.category', 'В данном разделе представлены средства управления категориями'); ?></p>

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'category-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
         array(
            'name'  => 'name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->name, array("/category/defaultAdmin/update", "alias" => $data->alias))',
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
)); ?>