<?php
$this->breadcrumbs = array(
    'Действия' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('RbacModule.rbac', 'Operations'), 'items' => array(
        array('icon' => 'plus-sign', 'label' => Yii::t('RbacModule.rbac', 'Create role'), 'url' => array('/rbac/rbacBackend/create')),
        array('icon' => 'pencil', 'label' => Yii::t('RbacModule.rbac', 'Update role'), 'url' => array('/rbac/rbacBackend/update', 'id' => $model->name)),
    )),
    array('label' => Yii::t('RbacModule.rbac', 'Roles'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'Manage roles'), 'url' => array('/rbac/rbacBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('RbacModule.rbac', 'Create role'), 'url' => array('/rbac/rbacBackend/create')),
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'Assign roles'), 'url' => array('/rbac/rbacBackend/userList')),
    ))
);
?>

<h3>Просмотр действия "<?php echo $model->name; ?>"</h3>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data' => $model,
        'attributes' => array(
            'name',
            array(
                'name' => 'type',
                'value' => $model->getType()
            ),
            'description',
            'bizrule',
            'data',
        ),
    )
); ?>
