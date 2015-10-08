<?php
/**
 * @var $model ProfileForm
 * @var $form CActiveForm
 */

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
?>
<div class="main__title grid">
    <h1 class="h2"><?= Yii::t('UserModule.user', 'Change password') ?></h1>
</div>
<div class="main__cart-box grid">
    <div class="grid-module-6">

        <?php
        $form = $this->beginWidget('CActiveForm', [
            'id' => 'profile-password-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ]); ?>

        <?= $form->errorSummary($model); ?>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'password'); ?>
            <?= $form->passwordField($model, 'password', ['class' => 'input input_big', 'autocomplete' => 'off']); ?>
            <?= $form->error($model, 'password') ?>
        </div>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'cPassword'); ?>
            <?= $form->passwordField($model, 'cPassword', [
                'class' => 'input input_big',
                'autocomplete' => 'off'
            ]); ?>
            <?= $form->error($model, 'cPassword') ?>
        </div>
        <div class="fast-order__inputs">
            <label class="checkbox">
                <input type="checkbox" value="1" id="show_pass"> <?= Yii::t('UserModule.user', 'show password') ?>
            </label>
        </div>
        <div class="fast-order__inputs">
            <?= CHtml::submitButton(Yii::t('UserModule.user', 'Change password'), [
                'id' => 'login-btn',
                'class' => 'btn btn_big btn_wide btn_white'
            ]) ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>