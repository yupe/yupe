<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => ['class' => 'well'],
    ]
); ?>
<div class="row">
    <div class="col-sm-6">
        <?=  $form->textFieldGroup($model, 'nick_name'); ?>
    </div>
    <div class="col-sm-6">
        <?=  $form->textFieldGroup($model, 'email'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?=  $form->textFieldGroup($model, 'first_name'); ?>
    </div>
    <div class="col-sm-6">
        <?=  $form->textFieldGroup($model, 'last_name'); ?>
    </div>
</div>

<div class="row">
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
    <div class="col-sm-6">
        <?=  $form->dropDownListGroup(
            $model,
            'access_level',
            [
                'widgetOptions' => [
                    'data'        => $model->getAccessLevelsList(),
                    'htmlOptions' => [
                        'empty' => '---',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <?=  $form->dropDownListGroup(
            $model,
            'gender',
            [
                'widgetOptions' => [
                    'data'        => $model->getGendersList(),
                    'htmlOptions' => [
                        'empty' => '---',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="form-actions">
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'buttonType' => 'submit',
            'context'    => 'primary',
            'icon'       => 'fa fa-search',
            'label'      => Yii::t('UserModule.user', 'Find user'),
        ]
    ); ?>

    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'buttonType' => 'reset',
            'context'    => 'danger',
            'icon'       => 'fa fa-times',
            'label'      => Yii::t('UserModule.user', 'Reset'),
        ]
    ); ?>
</div>

<?php $this->endWidget(); ?>
