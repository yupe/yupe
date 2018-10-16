<?php
$this->breadcrumbs = [
    Yii::t('RbacModule.rbac', 'Actions') => ['index'],
    Yii::t('RbacModule.rbac', 'Addition'),
];

$this->menu = [
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
    ],
];
?>

<h3><?php echo Yii::t('RbacModule.rbac', 'Adding item'); ?></h3>

<?php echo $this->renderPartial(
    '_form',
    ['model' => $model, 'operations' => $operations, 'tasks' => $tasks, 'roles' => $roles]
); ?>
