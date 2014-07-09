<?php
$this->breadcrumbs = array(
    'Действия' => array('index'),
    'список пользователей',
);

$this->menu = array(
    array('label' => Yii::t('RbacModule.rbac', 'Roles'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'Manage roles'), 'url' => array('index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('RbacModule.rbac', 'Create role'), 'url' => array('create')),
        array('icon' => 'user', 'label' => Yii::t('RbacModule.rbac', 'User list'), 'url' => array('userList')),
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
