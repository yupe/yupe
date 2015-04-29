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
    <?php echo Yii::t('UserModule.user', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('UserModule.user', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListGroup(
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
        <?php echo $form->dropDownListGroup(
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
        <?php echo $form->dropDownListGroup(
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
        <?php echo $form->textFieldGroup($model, 'token'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->labelEx($model, 'create_time'); ?>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-calendar"></i></span>
            <?php $this->widget(
                'bootstrap.widgets.TbDateTimePicker',
                [
                    'model'       => $model,
                    'attribute'   => 'create_time',
                    'htmlOptions' => [
                        'class' => 'span11',
                        'value' => !empty($model->create_time)
                                ? $model->beautifyDate($model->create_time, 'yyyy-MM-dd HH:mm')
                                : date('Y-m-d H:i')
                    ],
                ]
            ); ?>
        </div>
    </div>

    <div class="col-sm-6">
        <?php echo $form->labelEx($model, 'update_time'); ?>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-calendar"></i></span>
            <?php $this->widget(
                'bootstrap.widgets.TbDateTimePicker',
                [
                    'model'       => $model,
                    'attribute'   => 'update_time',
                    'htmlOptions' => [
                        'class' => 'span11',
                        'value' => !empty($model->update_time)
                                ? $model->beautifyDate($model->update_time, 'yyyy-MM-dd HH:mm')
                                : date('Y-m-d H:i')
                    ],
                ]
            ); ?>
        </div>
    </div>
</div>
<br/>
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
