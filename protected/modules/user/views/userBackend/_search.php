<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>
    <div class="row-fluid">
        <div class="span6">
            <?php echo $form->textFieldRow(
                $model, 'nick_name', array(
                    'size'      => 60,
                    'maxlength' => 150,
                    'class'     => 'span12'
                )
            ); ?>
        </div>
        <div class="span6">
            <?php echo $form->textFieldRow(
                $model, 'email', array(
                    'size'      => 60,
                    'maxlength' => 150,
                    'class'     => 'span12'
                )
            ); ?>
        </div>
    </div>
    
    <div class="row-fluid">
        <div class="span6">
            <?php echo $form->textFieldRow(
                $model, 'first_name', array(
                    'size'      => 60,
                    'maxlength' => 150,
                    'class'     => 'span12'
                )
            ); ?>
        </div>
        <div class="span6">
            <?php echo $form->textFieldRow(
                $model, 'last_name', array(
                    'size'      => 60,
                    'maxlength' => 150,
                    'class'     => 'span12'
                )
            ); ?>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <?php echo $form->textFieldRow($model, 'change_date', array('class' => 'span12')); ?>
        </div>
        <div class="span6">
            <?php echo $form->dropDownListRow(
                $model, 'gender', $model->getGendersList(), array(
                    'empty' => '---',
                    'class' => 'span12',
                )
            ); ?>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <?php echo $form->dropDownListRow(
                $model, 'status', $model->getStatusList(), array(
                    'empty' => '---',
                    'class' => 'span12',
                )
            ); ?>
        </div>
        <div class="span6">
            <?php echo $form->dropDownListRow(
                $model, 'access_level', $model->getAccessLevelsList(), array(
                    'empty' => '---',
                    'class' => 'span12',
                )
            ); ?>
        </div>
    </div>

    <div class="row-fluid">
        <?php echo $form->textFieldRow($model, 'last_visit'); ?>
    </div>

    <div class="form-actions">
        <?php $this->widget(
            'bootstrap.widgets.TbButton', array(
                'buttonType'  => 'submit',
                'type'        => 'primary',
                'icon'        => 'white search',
                'label'       => Yii::t('UserModule.user', 'Find user'),
            )
        ); ?>

        <?php $this->widget(
            'bootstrap.widgets.TbButton', array(
                'buttonType'  => 'reset',
                'type'        => 'danger',
                'icon'        => 'white remove',
                'label'       => Yii::t('UserModule.user', 'Reset'),
            )
        ); ?>
    </div>

<?php $this->endWidget(); ?>
