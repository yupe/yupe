<?php
$this->pageTitle = Yii::t('UserModule.user', 'Change email');
$this->breadcrumbs = array(
    Yii::t('UserModule.user', 'User profile') => array('/user/account/profile'),
    Yii::t('UserModule.user', 'Change email')
);

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'profile-email-form',
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
        <?php echo $form->textFieldGroup(
            $model,
            'email',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'autocomplete' => 'off',
                    ),
                ),
            )
        ); ?>
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
                'label'      => Yii::t('UserModule.user', 'Change email'),
            )
        ); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
