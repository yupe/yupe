<?php
$this->breadcrumbs = [
    Yii::t('RbacModule.rbac', 'RBAC') => ['index'],
    Yii::t('RbacModule.rbac', 'Addition'),
];

$this->menu = $this->module->getNavigation();
?>

<h3><?php echo Yii::t('RbacModule.rbac', 'Creating operation'); ?></h3>

<?php echo $this->renderPartial(
    '_form',
    ['model' => $model, 'operations' => $operations, 'tasks' => $tasks, 'roles' => $roles]
); ?>
