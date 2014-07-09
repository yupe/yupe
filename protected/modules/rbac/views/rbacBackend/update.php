<?php
$this->breadcrumbs = array(
    'Действия' => array('index'),
    $model->name => array('view', 'id' => $model->name),
    'Редактирование',
);

$this->menu = array(
    array('label' => Yii::t('RbacModule.rbac', 'Roles'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'Manage roles'), 'url' => array('/rbac/rbacBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('RbacModule.rbac', 'Create role'), 'url' => array('/rbac/rbacBackend/create')),
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'Assign roles'), 'url' => array('/rbac/rbacBackend/userList')),
    ))
);

?>

    <h3>
        Редактирование действия "<?php echo $model->description; ?>"
        <small>(<?php echo $model->getType() . ' ' . $model->name; ?>)</small>
    </h3>

<?php echo $this->renderPartial(
    '_form',
    array('model' => $model, 'operations' => $operations, 'tasks' => $tasks, 'roles' => $roles, 'checkedList' => $checkedList)
); ?>