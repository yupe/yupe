<?php
$this->breadcrumbs = [
    Yii::t('RbacModule.rbac', 'RBAC') => ['index'],
    Yii::t('RbacModule.rbac', 'Import'),
];

$this->menu = $this->module->getNavigation();
?>

<h3><?php echo Yii::t('RbacModule.rbac', 'Rules import'); ?></h3>

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
        <?php foreach ($modules as $moduleId => $moduleName): { ?>
            <div class="checkbox">
                <label>
                    <?php echo CHtml::checkBox(
                        'modules[]',
                        false,
                        ['value' => $moduleId]
                    ); ?><?php echo $moduleName; ?>
                    <span class='text-muted'>[<?php echo $moduleId; ?>]</span>
                </label>
            </div>
        <?php } endforeach; ?>
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
