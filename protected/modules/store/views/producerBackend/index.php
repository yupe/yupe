<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.producer', 'Producers') => ['/store/producerBackend/index'],
    Yii::t('StoreModule.store', 'Manage'),
];

$this->pageTitle = Yii::t('StoreModule.producer', 'Producers - manage');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.producer', 'Manage producers'), 'url' => ['/store/producerBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.producer', 'Create producer'), 'url' => ['/store/producerBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.producer', 'Producers'); ?>
        <small><?= Yii::t('StoreModule.store', 'administration'); ?></small>
    </h1>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'producer-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => [
            [
                'name' => 'image',
                'type' => 'raw',
                'value' => 'CHtml::image($data->getImageUrl(50, 50), "", array("width" => 50, "height" => 50, "class" => "img-thumbnail"))',
                'filter' => false
            ],
            [
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/store/producerBackend/update", "id" => $data->id))',
            ],
            [
                'name' => 'name_short',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name_short, array("/store/producerBackend/update", "id" => $data->id))',
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'slug',
                'editable' => [
                    'url'    => $this->createUrl('/store/producerBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'slug', ['class' => 'form-control']),
            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/store/producerBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Producer::STATUS_ACTIVE => ['class' => 'label-success'],
                    Producer::STATUS_NOT_ACTIVE => ['class' => 'label-info'],
                    Producer::STATUS_ZERO => ['class' => 'label-default'],
                ],
            ],
            [
                'header' => Yii::t('StoreModule.store', 'Products'),
                'value'  => function($data) {
                        return CHtml::link($data->productCount, ['/store/productBackend/index', "Product[producer_id]" => $data->id], ['class' => 'badge']);
                    },
                'type' => 'raw'
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
