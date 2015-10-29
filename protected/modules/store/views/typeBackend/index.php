<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.type', 'Product types') => ['/store/typeBackend/index'],
    Yii::t('StoreModule.store', 'Manage'),
];

$this->pageTitle = Yii::t('StoreModule.type', 'Product types - manage');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.type', 'Type manage'), 'url' => ['/store/typeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.type', 'Create type'), 'url' => ['/store/typeBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.type', 'Product types'); ?>
        <small><?= Yii::t('StoreModule.store', 'administration'); ?></small>
    </h1>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'type-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => [
            [
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/store/typeBackend/update", "id" => $data->id))',
            ],
            [
                'name'  => 'main_category_id',
                'value' => function($data) {
                        return $data->category ? $data->category->name : '---';
                    },
                'filter' => false
            ],
            [
                'header' => Yii::t('StoreModule.store', 'Products'),
                'value' => function($data) {
                        return CHtml::link($data->productCount, ['/store/productBackend/index', "Product[type_id]" => $data->id], ['class' => 'badge']);
                    },
                'type' => 'raw'
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
