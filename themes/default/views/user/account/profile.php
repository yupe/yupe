<?php
$this->pageTitle = Yii::t('UserModule.user', 'User profile');
$this->breadcrumbs = array(Yii::t('UserModule.user', 'User profile'));

Yii::app()->clientScript->registerCss('profile', "
    input.confirmed { border: 1px solid #88d395; }
    div.email-change-msg { display: none; } 
");

Yii::app()->clientScript->registerScript('regs', "
            $(function() {
                 $('#show_pass').click( function() {
                      $('#ProfileForm_password').prop('type', $(this).prop('checked')?'text':'password');
                      $('#ProfileForm_cPassword').prop('type', $(this).prop('checked')?'text':'password');
                 });
                 
                 var emailStatusEl = $('p.email-status-confirmed'),
                     loadedEmail = $('#ProfileForm_email').val();

                $('#ProfileForm_email').change(function(){
                    var currentEmail = $(this).val();

                    if(emailStatusEl){
                        if(currentEmail !== loadedEmail) {
                            $('#ProfileForm_email').removeClass('confirmed');
                            emailStatusEl.hide();
                            $('div.email-change-msg').show();
                        }else{
                            $('#ProfileForm_email').addClass('confirmed');
                            emailStatusEl.show();
                            $('div.email-change-msg').hide();
                        }
                    } else {
                        $('div.email-change-msg').show();
                    }
                });
                    
            });");

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', 
    array(
        'id'                     => 'profile-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'inlineErrors' => true,
        'htmlOptions' => array(
            'class' => 'well',
            'enctype' => 'multipart/form-data',
        )
    ));
?>

    <?php echo  $form->errorSummary($model); ?>

    <div class="row-fluid">
        <div class="span3">
            <?php $this->widget('AvatarWidget', array('user' => $user, 'noCache' => true)); ?>
        </div>
        <div class="span4">
            <?php echo $form->checkBoxRow($model, 'use_gravatar', array(
                'hint'=> Yii::t('UserModule.user','If you do not use Gravatar feel free to upload your own.')
            )); ?>
            
            <?php echo $form->fileFieldRow($model, 'avatar'); ?>
        </div>
    </div>

    <div class="row-fluid">
        <?php echo $form->textFieldRow($model, 'email', array(
            'autocomplete' => 'off',
            'class'=>'span6' . ( (Yii::app()->user->profile->getIsVerifyEmail() && !$model->hasErrors()) ? ' confirmed' : '' )
        )); ?>

        <?php if (Yii::app()->user->profile->getIsVerifyEmail() && !$model->hasErrors()):?>
            <p class="email-status-confirmed text-success">
                <?php echo Yii::t('UserModule.user','E-mail was verified');?>
            </p>
        <?php elseif( !$model->hasErrors() ):?>
            <p class="email-status-not-confirmed text-error">
                <?php echo Yii::t('UserModule.user','e-mail was not confirmed, please check you mail!');?>
            </p>
        <?php endif?>
       
    </div>


    <div class="row-fluid">
        <?php echo $form->textFieldRow($model, 'last_name', array('class' => 'span6')) ?>
    </div>

    <div class="row-fluid">
        <?php echo $form->textFieldRow($model, 'first_name', array('class' => 'span6')) ?>
    </div>

    <div class="row-fluid">
        <?php echo $form->textFieldRow($model, 'middle_name', array('class' => 'span6')) ?>
    </div>

    <div class="row-fluid">
        <?php echo $form->dropDownListRow($model, 'gender', User::model()->getGendersList(),array('class' => 'span6','data-original-title' => $model->getAttributeLabel('gender'), 'data-content' => User::model()->getAttributeDescription('gender'))); ?>
    </div>

    <div class="row-fluid">
        <?php echo $form->label($model,'birth_date');?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'birth_date',
                // additional javascript options for the date picker plugin
                'options'=>array(
                    'showAnim'=>'fold',
                    'dateFormat' => 'yy-mm-dd'
                ),
                'htmlOptions'=>array(
                    'style'=>'height:20px;'
                ),
            ));
        ?>
    </div>

    <div class="row-fluid">
        <?php echo $form->textFieldRow($model, 'location', array('class' => 'span6')) ?>
    </div>

    <div class="row-fluid">
        <?php echo $form->textFieldRow($model, 'site', array('class' => 'span6')) ?>
    </div>

    <div class="row-fluid">
        <?php echo $form->textAreaRow($model, 'about', array('class' => 'span6','rows' => 7));?>
    </div>

    <hr>
    
    <div class="row-fluid">
        <p class="password-change-msg muted span6">
            <?php echo Yii::t('UserModule.user','If you do not want to change password, leave fields empty.');?>
        </p>
    </div>
    
    <div class="row-fluid">
        <?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span6','autocomplete' => 'off'));?>
    </div>
        
    <div class="row-fluid">
        <?php echo $form->passwordFieldRow($model, 'cPassword', array('class'=>'span6','autocomplete' => 'off'));?>
        <label class="checkbox">
            <input type="checkbox" value="1" id="show_pass"> <?php echo Yii::t('UserModule.user','show password') ?>
        </label>
    </div>
        
    <?php if (is_array($this->module->profiles)&&count($this->module->profiles)):?>
        <?php foreach($this->module->profiles as $k=>$p):?>
            <?php $this->renderPartial("//".$k."/".$k."_profile", array("model"=>$p, "form"=>$form));?>
        <?php endforeach;?>
    <?php endif;?>

    <div class="row-fluid  control-group">
        
         <div class="row-fluid email-change-msg">
            <?php if (Yii::app()->user->profile->getIsVerifyEmail()) : ?>
                <p class="text-warning span6">
                    <?php echo Yii::t('UserModule.user','Warning! After changing your e-mail you will receive a message explaining how to verify it');?>
                </p>
            <?php endif;?>
        </div>  
        
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => Yii::t('UserModule.user','Save profile'),
        )
    ); ?>

    </div>
        
    <?php $this->endWidget(); ?>