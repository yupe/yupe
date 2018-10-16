<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ]
); ?>

<div class="row">
    <div class="col-sm-6">
        <?=  $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?=  $form->dropDownListGroup($model, 'type'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?=  $form->textAreaGroup($model, 'description'); ?>
    </div>
</div>

<div class="form-actions">
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'context' => 'primary',
            'label'   => Yii::t('RbacModule.rbac', 'Search'),
        ]
    ); ?>
</div>

<?php $this->endWidget(); ?>
