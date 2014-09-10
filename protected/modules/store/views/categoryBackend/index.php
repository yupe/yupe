<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.category', 'Categories') => array('/store/categoryBackend/index'),
    Yii::t('StoreModule.category', 'Manage'),
);

$this->pageTitle = Yii::t('StoreModule.category', 'Categories - manage');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.category', 'Category manage'), 'url' => array('/store/categoryBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.category', 'Create category'), 'url' => array('/store/categoryBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.category', 'Categories'); ?>
        <small><?php echo Yii::t('StoreModule.category', 'manage'); ?></small>
    </h1>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id' => 'category-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'actionsButtons' => [
            CHtml::link(
                Yii::t('YupeModule.yupe', 'Add'),
                ['/store/categoryBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns' => array(
            array(
                'name'   => 'image',
                'type'   => 'raw',
                'value'  => '$data->image ? CHtml::image($data->getImageUrl(50, 50, true), $data->name, array("width"  => 50, "height" => 50, "class" => "img-thumbnail")) : ""',
                'filter' => false
            ),
            array(
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/store/categoryBackend/update", "id" => $data->id))',
            ),
            array(
                'name' => 'alias',
                'type' => 'raw',
                'value' => 'CHtml::link($data->alias, array("/store/categoryBackend/update", "id" => $data->id))',
            ),
            array(
                'name' => 'parent_id',
                'value' => '$data->getParentName()',
                'filter' => CHtml::activeDropDownList($model, 'parent_id', StoreCategory::model()->getFormattedList(), array('encode' => false, 'empty' => '', 'class' => 'form-control'))
            ),
            array(
                'name' => 'status',
                'type' => 'raw',
                'filter' => $model->getStatusList(),
                'value'  => '$data->getStatus()'
            ),
            array(
                'header' => Yii::t('StoreModule.category', 'Products'),
                'value' => '$data->productCount'
            ),
            array(
                'class'  => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
