<?php
$this->breadcrumbs = array(
    Yii::t('RbacModule.rbac', 'Actions') => array('index'),
    Yii::t('RbacModule.rbac', 'Import'),
);

$this->menu = array(
    array('label' => Yii::t('RbacModule.rbac', 'Roles'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'Manage roles'), 'url' => array('/rbac/rbacBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('RbacModule.rbac', 'Create role'), 'url' => array('/rbac/rbacBackend/create')),
    )),
    array('label' => Yii::t('RbacModule.rbac', 'Users'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'Users'), 'url' => array('/rbac/rbacBackend/userList')),
    )),
);

?>

<h3><?php echo Yii::t('RbacModule.rbac','Rules import');?></h3>

<?php $form = $this->beginWidget(
    'CActiveForm',
    array(
        'id' => 'import-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array(
            'class' => 'well',
        ),
    )
); ?>

<div class="row-fluid">
    <?php foreach($modules as $moduleId => $moduleName):?>
    <label class="checkbox">
        <?php echo CHtml::checkBox('modules[]',false, array('value' => $moduleId));?><?php echo $moduleName;?> <span class='muted'>[<?php echo $moduleId;?>]</span>
    </label>
    <?php endforeach;?>
</div>

<br/>

<?php
$this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => Yii::t('RbacModule.rbac', 'Import'),
    )
);
?>

<?php $this->endWidget(); ?>

