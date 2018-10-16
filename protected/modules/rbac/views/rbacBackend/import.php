<?php
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
        <?php foreach ($modules as $moduleId => $moduleName): { ?>
            <div class="checkbox">
                <label>
                    <?=  CHtml::checkBox(
                        'modules[]',
                        false,
                        ['value' => $moduleId]
                    ); ?><?=  $moduleName; ?>
                    <span class='text-muted'>[<?=  $moduleId; ?>]</span>
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
