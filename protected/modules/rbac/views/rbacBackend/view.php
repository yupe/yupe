<?php
$this->breadcrumbs = [
    Yii::t('RbacModule.rbac', 'Actions') => ['index'],
    $model->name,
];

$this->menu = [
    [
        'label' => Yii::t('RbacModule.rbac', 'Operations'),
        'items' => [
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('RbacModule.rbac', 'Create role'),
                'url'   => ['/rbac/rbacBackend/create']
            ],
            [
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('RbacModule.rbac', 'Update role'),
                'url'   => ['/rbac/rbacBackend/update', 'id' => $model->name]
            ],
        ]
    ],
    [
        'label' => Yii::t('RbacModule.rbac', 'Roles'),
        'items' => [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('RbacModule.rbac', 'Manage roles'),
                'url'   => ['/rbac/rbacBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('RbacModule.rbac', 'Create role'),
                'url'   => ['/rbac/rbacBackend/create']
            ],
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('RbacModule.rbac', 'Assign roles'),
                'url'   => ['/rbac/rbacBackend/userList']
            ],
        ]
    ]
];
?>

<h3><?php echo Yii::t('RbacModule.rbac', 'View action'); ?> "<?php echo $model->name; ?>"</h3>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'name',
            [
                'name'  => 'type',
                'value' => $model->getType()
            ],
            'description',
            'bizrule',
            'data',
        ],
    ]
); ?>
