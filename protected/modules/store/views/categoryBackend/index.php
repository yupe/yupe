<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.store', 'Categories') => array('/store/categoryBackend/index'),
    Yii::t('StoreModule.store', 'Manage'),
);

$this->pageTitle = Yii::t('StoreModule.store', 'Categories - manage');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Category manage'), 'url' => array('/store/categoryBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Create category'), 'url' => array('/store/categoryBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Categories'); ?>
        <small><?php echo Yii::t('StoreModule.store', 'manage'); ?></small>
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
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/store/categoryBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    StoreCategory::STATUS_PUBLISHED => ['class' => 'label-success'],
                    StoreCategory::STATUS_DRAFT => ['class' => 'label-default'],
                ],
            ),
            array(
                'header' => Yii::t('StoreModule.store', 'Products'),
                'value' => '$data->productCount'
            ),
            array(
                'class'  => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
); ?>
