<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.type', 'Типы товаров') => ['/store/typeBackend/index'],
    Yii::t('StoreModule.type', 'Управление'),
];

$this->pageTitle = Yii::t('StoreModule.type', 'Типы товаров - управление');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.type', 'Управление типами'), 'url' => ['/store/typeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.type', 'Добавить тип'), 'url' => ['/store/typeBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.type', 'Типы товаров'); ?>
        <small><?php echo Yii::t('StoreModule.type', 'управление'); ?></small>
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
