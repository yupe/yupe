<?php
$this->breadcrumbs = array(
    Yii::t('RbacModule.rbac', 'Actions') => array('index'),
    Yii::t('RbacModule.rbac', 'Addition'),
);

$this->menu = array(
    array(
        'label' => Yii::t('RbacModule.rbac', 'Roles'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('RbacModule.rbac', 'Manage roles'),
                'url'   => array('/rbac/rbacBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('RbacModule.rbac', 'Create role'),
                'url'   => array('/rbac/rbacBackend/create')
            ),
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('RbacModule.rbac', 'Assign roles'),
                'url'   => array('/rbac/rbacBackend/userList')
            ),
        )
    ),
);
?>

<h3><?php echo Yii::t('RbacModule.rbac', 'Adding item'); ?></h3>

<?php echo $this->renderPartial(
    '_form',
    array('model' => $model, 'operations' => $operations, 'tasks' => $tasks, 'roles' => $roles)
); ?>
