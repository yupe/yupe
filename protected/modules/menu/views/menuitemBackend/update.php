<?php
$this->breadcrumbs = [
    Yii::t('MenuModule.menu', 'Menu')       => ['/menu/menuBackend/index'],
    Yii::t('MenuModule.menu', 'Menu items') => ['/menu/menuitemBackend/index'],
    $model->title                           => ['/menu/menuitemBackend/view', 'id' => $model->id],
    Yii::t('MenuModule.menu', 'Edit'),
];

$this->pageTitle = Yii::t('MenuModule.menu', 'Menu items - edit');

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
                'url'   => [
                    '/menu/menuitemBackend/update',
                    'id' => $model->id
                ]
            ],
            [
                'icon'  => 'fa fa-fw fa-eye',
                'label' => Yii::t('MenuModule.menu', 'View menu item'),
                'url'   => [
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
                    'confirm' => Yii::t('MenuModule.menu', 'Do you really want to remove menu item?'),
                    'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
                ],
            ],
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MenuModule.menu', 'Edit menu item'); ?><br/>
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
