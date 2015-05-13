<?php
/* @var $model ProfileForm */

$this->title = [Yii::t('UserModule.user', 'Change password'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [
    Yii::t('UserModule.user', 'User profile') => ['/user/profile/profile'],
    Yii::t('UserModule.user', 'Change password')
];

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
    [
        'id'                     => 'profile-password-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'htmlOptions'            => [
            'class' => 'well',
        ]
    ]
);
?>

<?= $form->errorSummary($model); ?>

<div class="row">
    <div class="col-xs-6">
        <?= $form->passwordFieldGroup(
            $model,
            'password',
            ['widgetOptions' => ['htmlOptions' => ['autocomplete' => 'off']]]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?= $form->passwordFieldGroup(
            $model,
            'cPassword',
            ['widgetOptions' => ['htmlOptions' => ['autocomplete' => 'off']]]
        ); ?>

    </div>
    <div class="col-xs-6">
        <br/>
        <label class="checkbox">
            <input type="checkbox" value="1" id="show_pass"> <?= Yii::t('UserModule.user', 'show password') ?>
        </label>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'context'    => 'primary',
                'label'      => Yii::t('UserModule.user', 'Change password'),
            ]
        ); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
