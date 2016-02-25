<?php
$this->breadcrumbs = [
    Yii::t('RbacModule.rbac', 'RBAC') => ['index'],
    Yii::t('RbacModule.rbac', 'Addition'),
];

$this->menu = $this->module->getNavigation();
?>

<h3><?=  Yii::t('RbacModule.rbac', 'Creating operation'); ?></h3>

<?=  $this->renderPartial(
    '_form',
    ['model' => $model, 'operations' => $operations, 'tasks' => $tasks, 'roles' => $roles]
); ?>
