<?php
$this->pageTitle = Yii::t('user', 'Профиль пользователя');
$this->breadcrumbs = array(Yii::t('user', 'Профиль пользователя'));

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

    <?php 
        echo  $form->errorSummary($model);
    ?>

    <div class="row-fluid">
        <div class="span3">
            <?php $this->widget('Avatar', array('user' => $user)); ?>
        </div>
        <div class="span4">
            <?php echo $form->checkBoxRow($model, 'use_gravatar', array(
                'hint'=> Yii::t('user','Если вы не пользуетесь Gravatar выберите аватарку из файла.')
            )); ?>
            
            <?php echo $form->fileFieldRow($model, 'avatar'); ?>
        </div>
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
        <?php echo $form->textFieldRow($model, 'email', array(
            'class'=>'span6' . ( (Yii::app()->user->profile->email_confirm && !$model->hasErrors()) ? ' confirmed' : '' )
        )); ?>
        
        <?php if (Yii::app()->user->profile->email_confirm && !$model->hasErrors())
            echo '<p class="email-status-confirmed text-success">' . Yii::t('user',"E-Mail проверен") . '</p>';
        elseif( !$model->hasErrors() )
            echo '<p class="email-status-not-confirmed text-error">' . Yii::t('user','e-mail не подтвержден, проверьте почту!') . '</p>';
        ?>
        
        <div class="row-fluid email-change-msg">
            <?php
            if (Yii::app()->user->profile->email_confirm)
                echo '<p class="text-warning span6">' . Yii::t('user','Внимание! После смены e-mail адреса, вам будет выслано письмо для его подтверждения.') . '</p>';
            ?>   
        </div>
        
    </div>

    <hr>
    
    <div class="row-fluid">
        <?php echo '<p class="password-change-msg muted span6">' . Yii::t('user','Если вы не желаете менять пароль &ndash; не заполняйте это и следующее поле') . '</p>'; ?>
    </div>
    
    <div class="row-fluid">
        <?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span6'));?>
        
        <label class="checkbox">
            <input type="checkbox" value="1" id="show_pass"> <?php echo Yii::t('user','не прятать') ?>
        </label>
    </div>
        
    <div class="row-fluid">
        <?php echo $form->passwordFieldRow($model, 'cPassword', array('class'=>'span6'));?>
    </div>
        
    <?php
    if (is_array($this->module->profiles)&&count($this->module->profiles))
        foreach($this->module->profiles as $k=>$p)
            $this->renderPartial("//".$k."/".$k."_profile", array("model"=>$p, "form"=>$form));
    ?>
    <div class="row-fluid  control-group">
        
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => Yii::t('user','Сохранить профиль'),
        )
    ); ?>

    </div>
        
    <?php $this->endWidget(); ?>