<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'                     => 'user-tokens-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well'],
    ]
); ?>

<div class="alert alert-info">
    <?=  Yii::t('UserModule.user', 'Fields with'); ?>
    <span class="required">*</span>
    <?=  Yii::t('UserModule.user', 'are required'); ?>
</div>

<?=  $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?=  $form->dropDownListGroup(
            $model,
            'user_id',
            [
                'widgetOptions' => [
                    'data'        => $model->getUserList(),
                    'htmlOptions' => [
                        'empty' => '---',
                    ],
                ],
            ]
        ); ?>
    </div>

    <div class="col-sm-6">
        <?=  $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data'        => $model->getStatusList(),
                    'htmlOptions' => [
                        'empty' => '---',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?=  $form->dropDownListGroup(
            $model,
            'type',
            [
                'widgetOptions' => [
                    'data'        => $model->getTypeList(),
                    'htmlOptions' => [
                        'empty' => '---',
                    ],
                ],
            ]
        ); ?>
    </div>

    <div class="col-sm-6">
        <?=  $form->textFieldGroup($model, 'token'); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'context'    => 'primary',
                'label'      => $model->isNewRecord ? Yii::t('UserModule.user', 'Create token and continue') : Yii::t(
                        'UserModule.user',
                        'Save token and continue'
                    ),
            ]
        ); ?>
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType'  => 'submit',
                'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
                'label'       => $model->isNewRecord ? Yii::t('UserModule.user', 'Create token and close') : Yii::t(
                        'UserModule.user',
                        'Save token and close'
                    ),
            ]
        ); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
