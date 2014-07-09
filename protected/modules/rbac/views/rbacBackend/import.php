<?php
$this->breadcrumbs = array(
    'Действия' => array('index'),
    'Импорт',
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

<h3>Импорт правил RBAC</h3>

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
    <?php echo CHtml::checkBoxList('modules[]', null, $modules, array(
        'template' => '<label class="checkbox">{input}{label}</label>',
        'separator' => '',
    ));?>
</div>

<br/>

<?php
$this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => Yii::t('RbacModule.rbac', 'Импортировать'),
    )
);
?>

<?php $this->endWidget(); ?>

