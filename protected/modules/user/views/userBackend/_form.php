<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'user-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
)); ?>
 
    <div class="alert alert-info">
        <?php echo Yii::t('UserModule.user', 'Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('UserModule.user', 'are required'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('nick_name') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'nick_name', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('nick_name'), 'data-content' => $model->getAttributeDescription('nick_name'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('email') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'email', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('email'), 'data-content' => $model->getAttributeDescription('email'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('last_name') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'last_name', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('last_name'), 'data-content' => $model->getAttributeDescription('last_name'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('first_name') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'first_name', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('first_name'), 'data-content' => $model->getAttributeDescription('first_name'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('middle_name') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'middle_name', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('middle_name'), 'data-content' => $model->getAttributeDescription('middle_name'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('site') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'site', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('site'), 'data-content' => $model->getAttributeDescription('site'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('birth_date') ? 'error' : ''; ?>">
        <?php echo $form->labelEx($model, 'birth_date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'     => $model,
            'attribute' => 'birth_date',
            'options'   => array('dateFormat' => 'yy-mm-dd'),
            'htmlOptions' => array('class' => 'span7')
        )); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('about') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('about'); ?>' data-content='<?php echo $model->getAttributeDescription('about'); ?>'>
            <?php
            $this->widget(
                $this->module->editor, array(
                    'model' => $model,
                    'attribute' => 'about',
                    'options' => $this->module->editorOptions,
                )
            ); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('gender') ? 'error' : ''; ?>"> 
        <?php echo $form->dropDownListRow($model, 'gender', $model->getGendersList(),array('class' => 'popover-help span7','data-original-title' => $model->getAttributeLabel('gender'), 'data-content' => $model->getAttributeDescription('gender'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : ''; ?>"> 
        <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(),array('class' => 'popover-help span7','data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('email_confirm') ? 'error' : ''; ?>"> 
        <?php echo $form->dropDownListRow($model, 'email_confirm', $model->getEmailConfirmStatusList(),array('class' => 'popover-help span7','data-original-title' => $model->getAttributeLabel('email_confirm'), 'data-content' => $model->getAttributeDescription('email_confirm'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('access_level') ? 'error' : ''; ?>">     
        <?php echo $form->dropDownListRow($model, 'access_level', $model->getAccessLevelsList(),array('class' => 'popover-help span7','data-original-title' => $model->getAttributeLabel('access_level'), 'data-content' => $model->getAttributeDescription('access_level'))); ?>        
    </div>

   <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('UserModule.user', 'Create user and continue') : Yii::t('UserModule.user', 'Save user and continue'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('UserModule.user', 'Create user and close') : Yii::t('UserModule.user', 'Save user and close'),
    )); ?>

<?php $this->endWidget(); ?>
