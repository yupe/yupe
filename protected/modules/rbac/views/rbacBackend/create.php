<?php
$this->breadcrumbs = array(
    'Действия' => array('index'),
    'новый элемент',
);

$this->menu = array(
    array('label' => Yii::t('RbacModule.rbac', 'Roles'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'Manage roles'), 'url' => array('/rbac/rbacBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('RbacModule.rbac', 'Create role'), 'url' => array('/rbac/rbacBackend/create')),
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'User list'), 'url' => array('/rbac/rbacBackend/userList')),
    )),

);

?>

<h1>Добавление действия</h1>

<?php echo $this->renderPartial('_form', array('model' => $model, 'operations' => $operations, 'tasks' => $tasks)); ?>