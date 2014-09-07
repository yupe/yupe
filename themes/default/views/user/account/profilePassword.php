<?php
/* @var $model ProfileForm */

$this->pageTitle = Yii::t('UserModule.user', 'Change password');
$this->breadcrumbs = array(
    Yii::t('UserModule.user', 'User profile') => array('/user/account/profile'),
    Yii::t('UserModule.user', 'Change password')
);

Yii::app()->clientScript->registerScript(
    'show-password',
    "$(function () {
    $('#show_pass').click(function () {
        $('#ProfilePasswordForm_password').prop('type', $(this).prop('checked') ? 'text' : 'password');
        $('#ProfilePasswordForm_cPassword').prop('type', $(this).prop('checked') ? 'text' : 'password');
    });
});"
);

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'profile-password-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'htmlOptions'            => array(
            'class' => 'well',
        )
    )
);
?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-xs-6">
        <?php echo $form->passwordFieldGroup(
            $model,
            'password',
            array('widgetOptions' => array('htmlOptions' => array('autocomplete' => 'off')))
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?php echo $form->passwordFieldGroup(
            $model,
            'cPassword',
            array('widgetOptions' => array('htmlOptions' => array('autocomplete' => 'off')))
        ); ?>

    </div>
    <div class="col-xs-6">
        <br/>
        <label class="checkbox">
            <input type="checkbox" value="1" id="show_pass"> <?php echo Yii::t('UserModule.user', 'show password') ?>
        </label>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'context'    => 'primary',
                'label'      => Yii::t('UserModule.user', 'Change password'),
            )
        ); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
