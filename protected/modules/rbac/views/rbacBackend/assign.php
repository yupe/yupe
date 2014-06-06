
<script type="text/javascript">
    $(document).ready(function () {
        $('input.root').click(function () {
            var data = $(this).is(':checked') ? true : false;
            $(this).next('ul').find('input').attr('checked', data);
        });
    });
</script>

<?php
$this->breadcrumbs = array(
    'Действия' => array('index'),
    'Назначение прав',
);

$this->menu = array(
    array('label' => Yii::t('RbacModule.rbac', 'Roles'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'Manage roles'), 'url' => array('/rbac/rbacBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('RbacModule.rbac', 'Create role'), 'url' => array('/rbac/rbacBackend/create')),
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'User list'), 'url' => array('/rbac/rbacBackend/userList')),
    )),

);

?>

<h1>Назначение прав пользователю "<?php echo $model->getFullName(); ?>"</h1>


<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'auth-item-assign-form',
        'enableAjaxValidation' => false,
    )
);


?>

<?php $this->widget('CTreeView', array('data' => $tree)); ?>

<div class="form-actions">
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => 'Сохранить',
        )
    );
    ?>
</div>

<?php $this->endWidget(); ?>