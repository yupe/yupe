<?php
/* @var $model Producer */
$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Producers') => ['/store/producerBackend/index'],
    $model->name,
];

$this->pageTitle = Yii::t('StoreModule.store', 'Producers - view');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Manage producers'), 'url' => ['/store/producerBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Create producer'), 'url' => ['/store/producerBackend/create']],
    ['label' => Yii::t('StoreModule.store', 'Producer') . ' «' . mb_substr($model->name_short, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.store', 'Update producer'),
        'url' => [
            '/store/producerBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.store', 'View producer'),
        'url' => [
            '/store/producerBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.store', 'Delete producer'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/store/producerBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('StoreModule.store', 'Do you really want to remove this producer?'),
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.store', 'Viewing producer'); ?><br/>
        <small>&laquo;<?= $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data' => $model,
        'attributes' => [
            'id',
            'name_short',
            'name',
            'slug',
            [
                'name' => 'status',
                'value' => $model->getStatusTitle(),
            ],
            'order',
            [
                'name' => 'image',
                'type' => 'raw',
                'value' => function($model){
                        return $model->image ? CHtml::image($model->getImageUrl()) : '';
                    },
            ],
            [
                'name' => 'short_description',
                'type' => 'html'
            ],
            [
                'name' => 'description',
                'type' => 'html'
            ],
            'meta_title',
            'meta_keywords',
            'meta_description'
        ],
    ]
); ?>
