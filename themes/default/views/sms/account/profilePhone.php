<?php
$this->pageTitle = Yii::t('UserModule.user', 'Change phone');
$this->breadcrumbs = [
    Yii::t('UserModule.user', 'User profile') => ['/user/account/profile'],
    Yii::t('UserModule.user', 'Change phone')
];

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'                     => 'profile-phone-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'htmlOptions'            => [
            'class' => 'well',
        ]
    ]
);
?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-xs-6">
        <?php echo $form->textFieldGroup(
            $model,
            'phone',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'autocomplete' => 'off',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php if (Yii::app()->user->profile->getIsVerifyPhone()) : { ?>
            <p class="alert alert-warning">
                <?php echo Yii::t(
                    'UserModule.user',
                    'Warning! After changing your phone you will receive a sms message to verify it'
                ); ?>
            </p>
        <?php } endif; ?>
    </div>
    <div class="col-xs-12">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'context'    => 'primary',
                'label'      => Yii::t('UserModule.user', 'Change phone'),
            ]
        ); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
