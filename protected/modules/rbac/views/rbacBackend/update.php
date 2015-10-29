<?php
$this->breadcrumbs = [
    Yii::t('RbacModule.rbac', 'RBAC') => ['index'],
    $model->name                         => ['view', 'id' => $model->name],
    Yii::t('RbacModule.rbac', 'Edit'),
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
            'label'       => Yii::t('RbacModule.rbac', 'Remove operation'),
            'url'         => '#',
            'linkOptions' => [
                'submit'  => ['/rbac/rbacBackend/delete', 'id' => $model->name],
                'confirm' => Yii::t('RbacModule.rbac', 'Do you really want to remove the operation?'),
                'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            ]
        ],
    ]
); ?>

<h3>
    <?php echo Yii::t('RbacModule.rbac', 'Edit item'); ?> "<?php echo $model->description; ?>"
    <small>(<?php echo $model->getType() . ' ' . $model->name; ?>)</small>
</h3>

<?php echo $this->renderPartial(
    '_form',
    [
        'model'       => $model,
        'operations'  => $operations,
        'tasks'       => $tasks,
        'roles'       => $roles,
        'checkedList' => $checkedList
    ]
); ?>
