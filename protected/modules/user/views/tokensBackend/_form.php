<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'user-tokens-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
    )
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
            array(
                'widgetOptions' => array(
                    'data'        => $model->getUserList(),
                    'htmlOptions' => array(
                        'empty' => '---',
                    ),
                ),
            )
        ); ?>
    </div>

    <div class="col-sm-6">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            array(
                'widgetOptions' => array(
                    'data'        => $model->getStatusList(),
                    'htmlOptions' => array(
                        'empty' => '---',
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListGroup(
            $model,
            'type',
            array(
                'widgetOptions' => array(
                    'data'        => $model->getTypeList(),
                    'htmlOptions' => array(
                        'empty' => '---',
                    ),
                ),
            )
        ); ?>
    </div>

    <div class="col-sm-6">
        <?php echo $form->textFieldGroup($model, 'token'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->labelEx($model, 'created'); ?>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-calendar"></i></span>
            <?php $this->widget(
                'bootstrap.widgets.TbDateTimePicker',
                array(
                    'model'       => $model,
                    'attribute'   => 'created',
                    'htmlOptions' => array(
                        'class' => 'span11',
                        'value' => !empty($model->created)
                                ? $model->beautifyDate($model->created, 'yyyy-MM-dd HH:mm')
                                : date('Y-m-d H:i')
                    ),
                )
            ); ?>
        </div>
    </div>

    <div class="col-sm-6">
        <?php echo $form->labelEx($model, 'updated'); ?>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-calendar"></i></span>
            <?php $this->widget(
                'bootstrap.widgets.TbDateTimePicker',
                array(
                    'model'       => $model,
                    'attribute'   => 'updated',
                    'htmlOptions' => array(
                        'class' => 'span11',
                        'value' => !empty($model->updated)
                                ? $model->beautifyDate($model->updated, 'yyyy-MM-dd HH:mm')
                                : date('Y-m-d H:i')
                    ),
                )
            ); ?>
        </div>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-xs-12">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'context'    => 'primary',
                'label'      => $model->isNewRecord ? Yii::t('UserModule.user', 'Create token and continue') : Yii::t(
                        'UserModule.user',
                        'Save token and continue'
                    ),
            )
        ); ?>
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType'  => 'submit',
                'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
                'label'       => $model->isNewRecord ? Yii::t('UserModule.user', 'Create token and close') : Yii::t(
                        'UserModule.user',
                        'Save token and close'
                    ),
            )
        ); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
