<?php
$this->breadcrumbs = array(
    'Действия' => array('admin'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('RbacModule.rbac', 'Roles'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'Manage roles'), 'url' => array('/rbac/rbacBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('RbacModule.rbac', 'Create role'), 'url' => array('/rbac/rbacBackend/create')),
    )),
    array('label' => Yii::t('RbacModule.rbac', 'Assign'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'Assign roles'), 'url' => array('/user/tokensBackend/index')),
    )),
);
?>

<h1>Просмотр действия "<?php echo $model->name; ?>"</h1>

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
