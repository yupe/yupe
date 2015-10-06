<?php
$this->breadcrumbs = [
    Yii::t('RbacModule.rbac', 'RBAC') => ['index'],
    Yii::t('RbacModule.rbac', 'Manage') => ['index'],
    $model->name,
];

$this->menu = array_merge(
    $this->module->getNavigation(),
    [
        ['label' => Yii::t('RbacModule.rbac', 'Operation') . ' «' . mb_substr($model->name, 0, 32) . '»', 'utf-8'],
        [
            'icon'        => 'fa fa-fw fa-pencil',
            'encodeLabel' => false,
            'label'       => Yii::t('RbacModule.rbac', 'Edit operation'),
            'url'         => [
                '/rbac/rbacBackend/update',
                'id' => $model->name
            ]
        ],
        [
            'icon'        => 'fa fa-fw fa-eye',
            'encodeLabel' => false,
            'label'       => Yii::t('RbacModule.rbac', 'View operation'),
            'url'         => [
                '/rbac/rbacBackend/view',
                'id' => $model->name
            ]
        ],
        [
            'icon'        => 'fa fa-fw fa-trash-o',
            'label'       => Yii::t('RbacModule.rbac', 'Remove rbac'),
            'url'         => '#',
            'linkOptions' => [
                'submit'  => ['/rbac/rbacBackend/delete', 'id' => $model->name],
                'confirm' => Yii::t('RbacModule.rbac', 'Do you really want to remove the operation?'),
                'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            ]
        ],
    ]
);
?>

<h3><?php echo Yii::t('RbacModule.rbac', 'View operation'); ?> "<?php echo $model->name; ?>"</h3>

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
