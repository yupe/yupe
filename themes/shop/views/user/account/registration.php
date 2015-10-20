<?php
/**
 * @var CActiveForm $form
 */
$this->title = [Yii::t('UserModule.user', 'Sign up'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('UserModule.user', 'Sign up')];
?>

<div class="main__title grid">
    <h1 class="h2"><?= Yii::t('UserModule.user', 'Sign up') ?></h1>
</div>
<div class="main__cart-box grid">
    <div class="grid-module-6">
        <?php $form = $this->beginWidget('CActiveForm', [
            'id' => 'registration-form',
            'enableClientValidation' => true
        ]); ?>

        <?= $form->errorSummary($model); ?>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'nick_name'); ?>
            <?= $form->textField($model, 'nick_name', ['class' => 'input input_big']); ?>
            <?= $form->error($model, 'nick_name') ?>
        </div>
        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'email'); ?>
            <?= $form->textField($model, 'email', ['class' => 'input input_big']); ?>
            <?= $form->error($model, 'email') ?>
        </div>
        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'password'); ?>
            <?= $form->passwordField($model, 'password', ['class' => 'input input_big']); ?>
            <?= $form->error($model, 'password') ?>
        </div>
        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'cPassword'); ?>
            <?= $form->passwordField($model, 'cPassword', ['class' => 'input input_big']); ?>
            <?= $form->error($model, 'cPassword') ?>
        </div>

        <?php if ($module->showCaptcha && CCaptcha::checkRequirements()): { ?>
            <div class="fast-order__inputs">
                <div class="column grid-module-3">
                    <?= $form->textField($model, 'verifyCode', [
                        'class' => 'input input_big',
                        'placeholder' => Yii::t('UserModule.user', 'Please enter the text from the image')
                    ]); ?>
                </div>
                <div class="column grid-module-3 pull-right">
                    <?php $this->widget(
                        'CCaptcha',
                        [
                            'showRefreshButton' => true,
                            'imageOptions' => [
                                'width' => '150',
                            ],
                            'buttonOptions' => [
                                'class' => 'btn btn_big btn_white pull-right',
                            ],
                            'buttonLabel' => '<i class="fa fa-fw fa-repeat"></i>',
                        ]
                    ); ?>
                </div>
            </div>
        <?php } endif; ?>

        <div class="fast-order__inputs">
            <div class="column grid-module-3">
                <?= CHtml::submitButton(Yii::t('UserModule.user', 'Sign up'), [
                    'class' => 'btn btn_big btn_wide btn_white'
                ]) ?>
            </div>
        </div>

        <?php if (Yii::app()->hasModule('social')): { ?>
            <div class="fast-order__inputs">
                <?php
                $this->widget('vendor.nodge.yii-eauth.EAuthWidget', [
                    'action' => '/social/login',
                    'predefinedServices' => ['google', 'facebook', 'vkontakte', 'twitter', 'github'],
                ]); ?>
            </div>
        <?php } endif; ?>

        <?php $this->endWidget(); ?>
        <!-- form -->
    </div>
</div>