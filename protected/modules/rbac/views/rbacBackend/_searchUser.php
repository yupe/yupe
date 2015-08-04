<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => ['class' => 'well'],
    ]
); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldGroup($model, 'nick_name'); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldGroup($model, 'email'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldGroup($model, 'first_name'); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldGroup($model, 'last_name'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <?php echo $form->datePickerGroup(
            $model,
            'create_time',
            [
                'widgetOptions' => [
                    'options' => [
                        'format'    => 'dd-mm-yyyy',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ],
                ],
                'prepend'       => '<i class="fa fa-calendar"></i>',
            ]
        ); ?>
    </div>
    <div class="col-sm-3">
        <?php echo $form->datePickerGroup(
            $model,
            'visit_time',
            [
                'widgetOptions' => [
                    'options' => [
                        'format'    => 'dd-mm-yyyy',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ],
                ],
                'prepend'       => '<i class="fa fa-calendar"></i>',
            ]
        ); ?>
    </div>
    <div class="col-sm-3">
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
    <div class="col-sm-6">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data'        => $model->getStatusList(),
                    'htmlOptions' => ['empty' => '---'],
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListGroup(
            $model,
            'access_level',
            [
                'widgetOptions' => [
                    'data'        => $model->getAccessLevelsList(),
                    'htmlOptions' => ['empty' => '---'],
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
            'label'      => Yii::t('RbacModule.rbac', 'Find user'),
        ]
    ); ?>

    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'buttonType' => 'reset',
            'context'    => 'danger',
            'icon'       => 'fa fa-fw fa-times',
            'label'      => Yii::t('RbacModule.rbac', 'Reset'),
        ]
    ); ?>
</div>

<?php $this->endWidget(); ?>
