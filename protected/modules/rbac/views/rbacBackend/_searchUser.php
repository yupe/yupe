<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => array('class' => 'well'),
    )
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
            'registration_date',
            array(
                'widgetOptions' => array(
                    'options' => array(
                        'format'    => 'dd-mm-yyyy',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ),
                ),
                'prepend'       => '<i class="fa fa-calendar"></i>',
            )
        ); ?>
    </div>
    <div class="col-sm-3">
        <?php echo $form->datePickerGroup(
            $model,
            'last_visit',
            array(
                'widgetOptions' => array(
                    'options' => array(
                        'format'    => 'dd-mm-yyyy',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ),
                ),
                'prepend'       => '<i class="fa fa-calendar"></i>',
            )
        ); ?>
    </div>
    <div class="col-sm-3">
        <?php echo $form->dropDownListGroup(
            $model,
            'gender',
            array(
                'widgetOptions' => array(
                    'data' => $model->getGendersList(),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            array(
                'widgetOptions' => array(
                    'data'        => $model->getStatusList(),
                    'htmlOptions' => array('empty' => '---'),
                ),
            )
        ); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListGroup(
            $model,
            'access_level',
            array(
                'widgetOptions' => array(
                    'data'        => $model->getAccessLevelsList(),
                    'htmlOptions' => array('empty' => '---'),
                ),
            )
        ); ?>
    </div>
</div>

<div class="form-actions">
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'context'    => 'primary',
            'icon'       => 'fa fa-search',
            'label'      => Yii::t('RbacModule.rbac', 'Find user'),
        )
    ); ?>

    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'reset',
            'context'    => 'danger',
            'icon'       => 'fa fa-fw fa-times',
            'label'      => Yii::t('RbacModule.rbac', 'Reset'),
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>
