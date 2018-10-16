<?php
$this->breadcrumbs = [
    Yii::t('MenuModule.menu', 'Menu')       => ['/menu/menuBackend/index'],
    Yii::t('MenuModule.menu', 'Menu items') => ['/menu/menuitemBackend/index'],
    $model->title,
];

$this->pageTitle = Yii::t('MenuModule.menu', 'Menu items - show');

$this->menu = [
    [
        'label' => Yii::t('MenuModule.menu', 'Menu'),
        'items' => [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MenuModule.menu', 'Manage menu'),
                'url'   => ['/menu/menuBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('MenuModule.menu', 'Create menu'),
                'url'   => ['/menu/menuBackend/create']
            ],
        ]
    ],
    [
        'label' => Yii::t('MenuModule.menu', 'Menu items'),
        'items' => [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MenuModule.menu', 'Manage menu items'),
                'url'   => ['/menu/menuitemBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('MenuModule.menu', 'Create menu item'),
                'url'   => ['/menu/menuitemBackend/create']
            ],
            ['label' => Yii::t('MenuModule.menu', 'Menu item') . ' «' . $model->title . '»'],
            [
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('MenuModule.menu', 'Change menu item'),
                'url'   => ['/menu/menuitemBackend/update', 'id' => $model->id]
            ],
            [
                'icon'        => 'fa fa-fw fa-eye',
                'encodeLabel' => false,
                'label'       => Yii::t('MenuModule.menu', 'View menu item'),
                'url'         => [
                    '/menu/menuitemBackend/view',
                    'id' => $model->id
                ]
            ],
            [
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('MenuModule.menu', 'Remove menu item'),
                'url'         => '#',
                'linkOptions' => [
                    'submit'  => ['/menu/menuitemBackend/delete', 'id' => $model->id],
                    'confirm' => Yii::t('MenuModule.menu', 'Do you really want to delete?'),
                    'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
                ],
            ],
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MenuModule.menu', 'Show menu item'); ?><br/>
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'id',
            'title',
            'href',
            'class',
            'title_attr',
            'before_link',
            'after_link',
            'target',
            'rel',
            [
                'name'  => 'menu_id',
                'value' => $model->menu->name,
            ],
            [
                'name'  => 'parent_id',
                'value' => $model->parent,
            ],
            [
                'name'  => 'condition_name',
                'value' => $model->conditionName,
            ],
            'sort',
            [
                'name'  => 'status',
                'value' => $model->getStatus(),
            ],
        ],
    ]
); ?>
