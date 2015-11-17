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
    <?php echo Yii::t('UserModule.user', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('UserModule.user', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'nick_name'
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'email'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'last_name'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'first_name'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'middle_name'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'site'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <?php echo $form->datePickerGroup(
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
    <div class="col-sm-2">
        <div class="form-group">
            <?php echo $form->labelEx($model,'phone',['class' => 'control-label']); ?>
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
            <?php echo $form->error($model,'phone'); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php echo $form->labelEx($model, 'about'); ?>
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

<br/>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
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
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data' => $model->getStatusList(),
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
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

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'access_level',
            [
                'widgetOptions' => [
                    'data' => $model->getAccessLevelsList(),
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
