<script type="text/javascript">
    $(document).ready(function () {
        function changeChildNodes(elem) {
            $(elem).closest('li').find('input').attr('checked', elem.checked);
        }

        $('input.auth-item').change(function () {
            // смысл этой ужасной конструкции в том, чтобы ветки с одинаковыми именами отключались и включались согласованно
            // нужно сделать, чтобы и при выборе родительского узла для всех дочерних происходило тоже самое и выключались
            // узлы в других ролях
            $('input[value="' + this.value + '"]:not(#' + this.id + ')').attr('checked', this.checked).closest('li').find('input').attr('checked', this.checked);
            changeChildNodes(this);
        });

        // для того, чтобы дерево было развернуто только до второго уровня, как сделать это нормально не ясно
        setTimeout(function () {
            $('ul.treeview > li > div.hitarea').click();
        }, 200);
    });
</script>

<?php $this->breadcrumbs = [
    Yii::t('RbacModule.rbac', 'RBAC')   => ['index'],
    Yii::t('RbacModule.rbac', 'User list') => ['userList'],
    Yii::t('RbacModule.rbac', 'Rights assignment'),
];

$this->menu = array_merge(
    $this->module->getNavigation(),
    [
        ['label' => Yii::t('RbacModule.rbac', 'User Rights Assignment')],
        [
            'icon'        => 'fa fa-fw fa-pencil',
            'encodeLabel' => false,
            'label'       => Yii::t('RbacModule.rbac', 'Roles'),
            'url'         => [
                '/rbac/rbacBackend/assign',
                'id' => $model->id
            ]
        ],

    ]
); ?>

<h3><?php echo Yii::t('RbacModule.rbac', 'User Rights Assignment'); ?> "<?php echo $model->getFullName(); ?>"</h3>

<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'                   => 'auth-item-assign-form',
        'enableAjaxValidation' => false,
    ]
);

?>

<?php Yii::app()->getClientScript()->registerCss('checkbox-margin', ".checkbox {margin: 0;}"); ?>

<div class="form-group">
    <?php $this->widget('CTreeView', ['data' => $tree, 'collapsed' => true, 'animated' => 'normal']); ?>
</div>

<div class="form-actions">
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'buttonType' => 'submit',
            'context'    => 'primary',
            'label'      => Yii::t('RbacModule.rbac', 'Save'),
        ]
    );
    ?>
</div>

<?php $this->endWidget(); ?>
