<?php
$this->pageTitle = Yii::t('UserModule.user', 'User profile');
$this->breadcrumbs = array(Yii::t('UserModule.user', 'User profile'));

Yii::app()->clientScript->registerCss(
    'profile',
    "
    input.confirmed { border: 1px solid #88d395; }
    div.email-change-msg { display: none; }
"
);

Yii::app()->clientScript->registerScript(
    'regs',
    "
            $(function () {
                 $('#show_pass').click( function () {
                      $('#ProfileForm_password').prop('type', $(this).prop('checked')?'text':'password');
                      $('#ProfileForm_cPassword').prop('type', $(this).prop('checked')?'text':'password');
                 });

                 var emailStatusEl = $('p.email-status-confirmed'),
                     loadedEmail = $('#ProfileForm_email').val();

                $('#ProfileForm_email').change(function () {
                    var currentEmail = $(this).val();

                    if (emailStatusEl) {
                        if (currentEmail !== loadedEmail) {
                            $('#ProfileForm_email').removeClass('confirmed');
                            emailStatusEl.hide();
                            $('div.email-change-msg').show();
                        } else {
                            $('#ProfileForm_email').addClass('confirmed');
                            emailStatusEl.show();
                            $('div.email-change-msg').hide();
                        }
                    } else {
                        $('div.email-change-msg').show();
                    }
                });

            });"
);

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'profile-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array(
            'class'   => 'well',
            'enctype' => 'multipart/form-data',
        )
    )
);
?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-xs-3">
        <?php $this->widget('AvatarWidget', array('user' => $user, 'noCache' => true)); ?>
    </div>
    <div class="col-xs-9">
        <?php echo $form->checkBoxGroup(
            $model,
            'use_gravatar',
            array(
                'hint' => Yii::t('UserModule.user', 'If you do not use Gravatar feel free to upload your own.')
            )
        ); ?>

        <?php echo $form->fileFieldGroup(
            $model,
            'avatar',
            array('widgetOptions' => array('htmlOptions' => array('style' => 'background: inherit;')))
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?php echo $form->textFieldGroup(
            $model,
            'email',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'autocomplete' => 'off',
                        'class'        => ((Yii::app()->user->profile->getIsVerifyEmail() && !$model->hasErrors(
                                )) ? ' confirmed' : '')
                    ),
                ),
            )
        ); ?>
        <?php if (Yii::app()->user->profile->getIsVerifyEmail() && !$model->hasErrors()): { ?>
            <p class="email-status-confirmed text-success">
                <?php echo Yii::t('UserModule.user', 'E-mail was verified'); ?>
            </p>
        <?php } elseif (!$model->hasErrors()): { ?>
            <p class="email-status-not-confirmed text-error">
                <?php echo Yii::t('UserModule.user', 'e-mail was not confirmed, please check you mail!'); ?>
            </p>
        <?php } endif ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?php echo $form->textFieldGroup($model, 'last_name') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?php echo $form->textFieldGroup($model, 'first_name') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?php echo $form->textFieldGroup($model, 'middle_name') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?php echo $form->dropDownListGroup(
            $model,
            'gender',
            array(
                'widgetOptions' => array(
                    'data'        => User::model()->getGendersList(),
                    'htmlOptions' => array(
                        'data-original-title' => $model->getAttributeLabel('gender'),
                        'data-content'        => User::model()->getAttributeDescription('gender')
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-3">
        <?php echo $form->datePickerGroup(
            $model,
            'birth_date',
            array(
                'widgetOptions' => array(
                    'options' => array(
                        'format' => 'yy-mm-dd',
                    ),
                ),
                'prepend'       => '<i class="glyphicon glyphicon-calendar"></i>'
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-8">
        <?php echo $form->textFieldGroup($model, 'location') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-8">
        <?php echo $form->textFieldGroup($model, 'site') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php echo $form->textAreaGroup(
            $model,
            'about',
            array('widgetOptions' => array('htmlOptions' => array('rows' => 7)))
        ); ?>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-xs-12">
        <p class="password-change-msg muted span6">
            <?php echo Yii::t('UserModule.user', 'If you do not want to change password, leave fields empty.'); ?>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-xs-3">
        <?php echo $form->passwordFieldGroup(
            $model,
            'password',
            array('widgetOptions' => array('htmlOptions' => array('autocomplete' => 'off')))
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-3">
        <?php echo $form->passwordFieldGroup(
            $model,
            'cPassword',
            array('widgetOptions' => array('htmlOptions' => array('autocomplete' => 'off')))
        ); ?>

    </div>
    <div class="col-xs-3">
        <br/>
        <label class="checkbox">
            <input type="checkbox" value="1" id="show_pass"> <?php echo Yii::t('UserModule.user', 'show password') ?>
        </label>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php if (is_array($this->module->profiles) && count($this->module->profiles)): { ?>
            <?php foreach ($this->module->profiles as $k => $p): { ?>
                <?php $this->renderPartial("//" . $k . "/" . $k . "_profile", array("model" => $p, "form" => $form)); ?>
            <?php } endforeach; ?>
        <?php } endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php if (Yii::app()->user->profile->getIsVerifyEmail()) : { ?>
            <p class="alert alert-warning">
                <?php echo Yii::t(
                    'UserModule.user',
                    'Warning! After changing your e-mail you will receive a message explaining how to verify it'
                ); ?>
            </p>
        <?php } endif; ?>
    </div>
    <div class="col-xs-12">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'context'    => 'primary',
                'label'      => Yii::t('UserModule.user', 'Save profile'),
            )
        ); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
