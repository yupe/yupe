<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'method' => 'get',
        'type' => 'vertical',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>
    <div class="row-fluid">
        <div class="span6">
            <?php echo $form->textFieldRow(
                $model, 'nick_name', array(
                    'size' => 60,
                    'maxlength' => 150,
                    'class' => 'input-block-level'
                )
            ); ?>
        </div>
        <div class="span6">
            <?php echo $form->textFieldRow(
                $model, 'email', array(
                    'size' => 60,
                    'maxlength' => 150,
                    'class' => 'input-block-level'
                )
            ); ?>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <?php echo $form->textFieldRow(
                $model, 'first_name', array(
                    'size' => 60,
                    'maxlength' => 150,
                    'class' => 'input-block-level'
                )
            ); ?>
        </div>
        <div class="span6">
            <?php echo $form->textFieldRow(
                $model, 'last_name', array(
                    'size' => 60,
                    'maxlength' => 150,
                    'class' => 'input-block-level'
                )
            ); ?>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span3">
            <?php echo $form->datepickerRow($model, 'registration_date', array(
                    'options' => array(
                        'format' => 'dd-mm-yyyy',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ),
                    'htmlOptions' => array(
                        'class' => 'input-block-level'
                    ),
                ),
                array(
                    'prepend' => '<i class="icon-calendar"></i>',
                ));
            ?>
        </div>
        <div class="span3">
            <?php echo $form->datepickerRow($model, 'last_visit', array(
                    'options' => array(
                        'format' => 'dd-mm-yyyy',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ),
                    'htmlOptions' => array(
                        'class' => 'input-block-level'
                    ),
                ),
                array(
                    'prepend' => '<i class="icon-calendar"></i>',
                ));
            ?>
        </div>
        <div class="span3">
            <?php echo $form->dropDownListRow(
                $model, 'gender', $model->getGendersList(), array(
                    'empty' => '---',
                    'class' => 'input-block-level',
                )
            ); ?>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <?php echo $form->dropDownListRow(
                $model, 'status', $model->getStatusList(), array(
                    'empty' => '---',
                    'class' => 'input-block-level',
                )
            ); ?>
        </div>
        <div class="span6">
            <?php echo $form->dropDownListRow(
                $model, 'access_level', $model->getAccessLevelsList(), array(
                    'empty' => '---',
                    'class' => 'input-block-level',
                )
            ); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php $this->widget(
            'bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'icon' => 'white search',
                'label' => Yii::t('RbacModule.rbac', 'Find user'),
            )
        ); ?>

        <?php $this->widget(
            'bootstrap.widgets.TbButton', array(
                'buttonType' => 'reset',
                'type' => 'danger',
                'icon' => 'white remove',
                'label' => Yii::t('RbacModule.rbac', 'Reset'),
            )
        ); ?>
    </div>

<?php $this->endWidget(); ?>