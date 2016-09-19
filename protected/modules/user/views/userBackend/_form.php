<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id' => 'user-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => ['class' => 'well'],
    ]
); ?>

<div class="alert alert-info">
    <?=  Yii::t('UserModule.user', 'Fields with'); ?>
    <span class="required">*</span>
    <?=  Yii::t('UserModule.user', 'are required'); ?>
</div>

<?=  $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-4">
        <?=  $form->textFieldGroup(
            $model,
            'nick_name'
        ); ?>
    </div>
    <div class="col-sm-5">
        <?=  $form->textFieldGroup($model, 'email'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <?=  $form->textFieldGroup($model, 'last_name'); ?>
    </div>
    <div class="col-sm-3">
        <?=  $form->textFieldGroup($model, 'first_name'); ?>
    </div>
    <div class="col-sm-3">
        <?=  $form->textFieldGroup($model, 'middle_name'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <?=  $form->labelEx($model,'phone',['class' => 'control-label']); ?>
            <?php $this->widget(
                'CMaskedTextField',
                [
                    'model' => $model,
                    'attribute' => 'phone',
                    'mask' => $this->module->phoneMask,
                    'placeholder' => '*',
                    'htmlOptions' => [
                        'class' => 'form-control'
                    ]
                ]
            ); ?>
            <?=  $form->error($model,'phone'); ?>
        </div>
    </div>
    <div class="col-sm-3">
        <?=  $form->textFieldGroup($model, 'site'); ?>
    </div>
</div>



<div class="row">
    <div class="col-sm-3">
        <?=  $form->datePickerGroup(
            $model,
            'birth_date',
            [
                'widgetOptions' => [
                    'options' => [
                        'format' => 'yyyy-mm-dd',
                        'weekStart' => 1,
                        'autoclose' => true,
                        'orientation' => 'auto right',
                        'startView' => 2,
                    ],
                ],
                'prepend' => '<i class="fa fa-calendar"></i>',
            ]
        ); ?>
    </div>
    <div class="col-sm-3">
        <?=  $form->dropDownListGroup(
            $model,
            'gender',
            [
                'widgetOptions' => [
                    'data' => $model->getGendersList(),
                ],
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?=  $form->labelEx($model, 'about'); ?>
        <?php
        $this->widget(
            $this->module->getVisualEditor(),
            [
                'model' => $model,
                'attribute' => 'about',
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <?=  $form->dropDownListGroup(
            $model,
            'access_level',
            [
                'widgetOptions' => [
                    'data' => $model->getAccessLevelsList(),
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-3">
        <?=  $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data' => $model->getStatusList(),
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-3">
        <?=  $form->dropDownListGroup(
            $model,
            'email_confirm',
            [
                'widgetOptions' => [
                    'data' => $model->getEmailConfirmStatusList(),
                ],
            ]
        ); ?>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->isNewRecord ? Yii::t('UserModule.user', 'Create user and continue') : Yii::t(
            'UserModule.user',
            'Save user and continue'
        ),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->isNewRecord ? Yii::t('UserModule.user', 'Create user and close') : Yii::t(
            'UserModule.user',
            'Save user and close'
        ),
    ]
); ?>

<?php $this->endWidget(); ?>
