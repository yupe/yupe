<?php
$this->breadcrumbs = array(
    Yii::t('RbacModule.rbac', 'Actions') => array('index'),
    $model->name,
);

$this->menu = array(
    array(
        'label' => Yii::t('RbacModule.rbac', 'Operations'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('RbacModule.rbac', 'Create role'),
                'url'   => array('/rbac/rbacBackend/create')
            ),
            array(
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('RbacModule.rbac', 'Update role'),
                'url'   => array('/rbac/rbacBackend/update', 'id' => $model->name)
            ),
        )
    ),
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
    )
);
?>

<h3><?php echo Yii::t('RbacModule.rbac', 'View action'); ?> "<?php echo $model->name; ?>"</h3>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'name',
            array(
                'name'  => 'type',
                'value' => $model->getType()
            ),
            'description',
            'bizrule',
            'data',
        ),
    )
); ?>
