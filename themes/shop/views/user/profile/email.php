<?php
/**
 * @var CActiveForm $form
 */
$this->title = [Yii::t('UserModule.user', 'Change email'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [
    Yii::t('UserModule.user', 'User profile') => ['/user/profile/profile'],
    Yii::t('UserModule.user', 'Change email')
];
?>
<div class="main__title grid">
    <h1 class="h2"><?= Yii::t('UserModule.user', 'Change email') ?></h1>
</div>
<div class="main__cart-box grid">
    <div class="grid-module-6">
        <?php
        $form = $this->beginWidget('CActiveForm', [
            'id' => 'profile-email-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ]); ?>

        <?= $form->errorSummary($model); ?>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'email'); ?>
            <?= $form->textField($model, 'email', ['class' => 'input input_big']); ?>
            <?= $form->error($model, 'email') ?>
        </div>

        <div class="fast-order__inputs">
            <?php if (Yii::app()->getUser()->profile->getIsVerifyEmail()) : { ?>
                <p class="errorSummary">
                    <?= Yii::t(
                        'UserModule.user',
                        'Warning! After changing your e-mail you will receive a message explaining how to verify it'
                    ); ?>
                </p>
            <?php } endif; ?>
        </div>
        <div class="fast-order__inputs">
            <?= CHtml::submitButton(Yii::t('UserModule.user', 'Change email'), [
                'id' => 'login-btn',
                'class' => 'btn btn_big btn_wide btn_white'
            ]) ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>