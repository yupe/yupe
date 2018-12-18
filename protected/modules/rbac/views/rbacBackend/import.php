<?php
/* @var $modules array */

$this->breadcrumbs = [
    Yii::t('RbacModule.rbac', 'RBAC') => ['index'],
    Yii::t('RbacModule.rbac', 'Import'),
];

$this->menu = $this->module->getNavigation();
?>

<h3><?=  Yii::t('RbacModule.rbac', 'Rules import'); ?></h3>

<?php $form = $this->beginWidget(
    'CActiveForm',
    [
        'id'                   => 'import-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => [
            'class' => 'well',
        ],
    ]
); ?>

<div class="row">
    <div class="col-sm-12">
        <?php
        array_walk($modules, function (&$item, $key) {
            $item .= " <span class='text-muted'>[{$key}]</span>";
        });
        ?>
        <?= CHtml::checkBoxList(
            'modules[]',
            [],
            $modules,
            [
                'separator' => "\n",
                'checkAll' => Yii::t('RbacModule.rbac', 'Select all'),
                'template' => "<div class='checkbox'>{beginLabel}{input} {labelTitle}{endLabel}</div>"
            ]
        ) ?>
    </div>
</div>

<br/>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => Yii::t('RbacModule.rbac', 'Import'),
    ]
); ?>

<?php $this->endWidget(); ?>
