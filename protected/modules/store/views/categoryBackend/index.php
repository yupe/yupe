<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.category', 'Categories') => ['/store/categoryBackend/index'],
    Yii::t('StoreModule.store', 'Manage'),
];

$this->pageTitle = Yii::t('StoreModule.category', 'Categories - manage');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.category', 'Manage categories'), 'url' => ['/store/categoryBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.category', 'Create category'), 'url' => ['/store/categoryBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.category', 'Categories'); ?>
        <small><?= Yii::t('StoreModule.store', 'administration'); ?></small>
    </h1>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'category-grid',
        'sortableRows'      => true,
        'sortableAjaxSave'  => true,
        'sortableAttribute' => 'sort',
        'sortableAction'    => '/store/categoryBackend/sortable',
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
        'columns' => [
            [
                'name'   => 'image',
                'type'   => 'raw',
                'value'  => '$data->image ? CHtml::image($data->getImageUrl(50, 50), $data->name, array("width"  => 50, "height" => 50, "class" => "img-thumbnail")) : ""',
                'filter' => false
            ],
            [
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/store/categoryBackend/update", "id" => $data->id))',
            ],
            [
                'name' => 'slug',
                'type' => 'raw',
                'value' => 'CHtml::link($data->slug, array("/store/categoryBackend/update", "id" => $data->id))',
            ],
            [
                'name' => 'parent_id',
                'value' => '$data->getParentName()',
                'filter' => CHtml::activeDropDownList($model, 'parent_id', StoreCategory::model()->getFormattedList(), ['encode' => false, 'empty' => '', 'class' => 'form-control'])
            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/store/categoryBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    StoreCategory::STATUS_PUBLISHED => ['class' => 'label-success'],
                    StoreCategory::STATUS_DRAFT => ['class' => 'label-default'],
                ],
            ],
            [
                'header' => Yii::t('StoreModule.store', 'Products'),
                'value' => function($data) {
                        return CHtml::link($data->productCount, ['/store/productBackend/index', "Product[category_id]" => $data->id], ['class' => 'badge']);
                    },
                'type' => 'raw'
            ],
            [
                'class'  => 'yupe\widgets\CustomButtonColumn',
                'buttons' => [
                    'front_view' => [
                        'visible' => function ($row, $data) {
                                return $data->status == StoreCategory::STATUS_PUBLISHED;
                            }
                    ]
                ]
            ],
        ],
    ]
); ?>
