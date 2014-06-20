<?php
    $this->breadcrumbs = array(      
        Yii::t('ShopModule.category', 'Categories') => array('/shop/categoryBackend/index'),
        Yii::t('ShopModule.category', 'Manage'),
    );

    $this->pageTitle = Yii::t('ShopModule.category', 'Categories - manage');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.category', 'Category manage'), 'url' => array('/shop/categoryBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.category', 'Create category'), 'url' => array('/shop/categoryBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.category', 'Categories'); ?>
        <small><?php echo Yii::t('ShopModule.category', 'manage'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('ShopModule.category', 'Find category'), '#', array('class' => 'search-button')); ?>
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

<p><?php echo Yii::t('ShopModule.category', 'This section describes category management'); ?></p>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'category-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'  => 'id',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->id, array("/shop/categoryBackend/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->name, array("/shop/categoryBackend/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'alias',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->alias, array("/shop/categoryBackend/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'parent_id',
            'value' => '$data->getParentName()',
			'filter' => CHtml::activeDropDownList($model, 'parent_id', ShopCategory::model()->getFormattedList(), array('encode' => false, 'empty' => ''))
        ),
        array(
            'name'  => 'image',
            'type'  => 'raw',
            'value' => '$data->image ? CHtml::image($data->getImageUrl(50, 50, true), $data->name, array("width"  => 50, "height" => 50)) : "---"',
        ),
        array(
            'name'  => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status")',
            'filter' => $model->getStatusList()
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>