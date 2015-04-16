<?php
$this->breadcrumbs = [
    Yii::t('CategoryModule.category', 'Categories') => ['index'],
    $model->name,
];

$this->pageTitle = Yii::t('CategoryModule.category', 'Categories - show');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('CategoryModule.category', 'Category manage'),
        'url'   => ['/category/categoryBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('CategoryModule.category', 'Create category'),
        'url'   => ['/category/categoryBackend/create']
    ],
    ['label' => Yii::t('CategoryModule.category', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('CategoryModule.category', 'Change category'),
        'url'   => [
            '/category/categoryBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('CategoryModule.category', 'View category'),
        'url'   => [
            '/category/categoryBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('CategoryModule.category', 'Remove category'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/category/categoryBackend/delete', 'id' => $model->id],
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('CategoryModule.category', 'Do you really want to remove category?'),
            'csrf'    => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CategoryModule.category', 'Show category'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'id',
            [
                'name'  => 'parent_id',
                'value' => $model->getParentName(),
            ],
            'name',
            'slug',
            [
                'name'  => 'image',
                'type'  => 'raw',
                'value' => $model->image
                    ? CHtml::image($model->getImageUrl(300, 300), $model->name)
                    : '---',
            ],
            [
                'name' => 'description',
                'type' => 'raw'
            ],
            [
                'name' => 'short_description',
                'type' => 'raw'
            ],
            [
                'name'  => 'status',
                'value' => $model->getStatus(),
            ],
        ],
    ]
); ?>
