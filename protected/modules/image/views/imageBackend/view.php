<?php
$this->breadcrumbs = [
    Yii::t('ImageModule.image', 'Images') => ['/image/imageBackend/index'],
    $model->name,
];

$this->pageTitle = Yii::t('ImageModule.image', 'Images - show');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('ImageModule.image', 'Image management'),
        'url'   => ['/image/imageBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('ImageModule.image', 'Add image'),
        'url'   => ['/image/imageBackend/create']
    ],
    ['label' => Yii::t('ImageModule.image', 'Image') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('ImageModule.image', 'Edit image'),
        'url'   => [
            '/image/imageBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('ImageModule.image', 'View image'),
        'url'   => [
            '/image/imageBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('ImageModule.image', 'Remove image'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/image/imageBackend/delete', 'id' => $model->id],
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('ImageModule.image', 'Do you really want to remove image?'),
            'csrf'    => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1><?php echo Yii::t('ImageModule.image', 'Show image'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'id',
            'category_id',
            'parent_id',
            'name',
            'description',
            [
                'name'  => 'file',
                'type'  => 'raw',
                'label' => Yii::t('ImageModule.image', 'Link'),
                'value' => CHtml::link($model->getImageUrl(), $model->getImageUrl()),
            ],
            [
                'name'  => 'file',
                'type'  => 'raw',
                'value' => CHtml::image($model->getImageUrl(100, 100), $model->alt),
            ],
            'create_time',
            [
                'name'  => 'user_id',
                'value' => $model->userName,
            ],
            'alt',
            [
                'name'  => 'type',
                'value' => $model->getType(),
            ],
            [
                'name'  => 'status',
                'value' => $model->getStatus(),
            ]
        ],
    ]
); ?>
