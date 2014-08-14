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

<p><?php echo Yii::t('StoreModule.category', 'This section describes category management'); ?></p>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id' => 'category-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
            array(
                'name' => 'id',
                'type' => 'raw',
                'value' => 'CHtml::link($data->id, array("/store/categoryBackend/update", "id" => $data->id))',
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
                'name' => 'image',
                'type' => 'raw',
                'value' => '$data->image ? CHtml::image($data->getImageUrl(50, 50, true), $data->name, array("width"  => 50, "height" => 50, "class" => "img-thumbnail")) : ""',
            ),
            array(
                'name' => 'status',
                'type' => 'raw',
                'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status")',
                'filter' => $model->getStatusList()
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
