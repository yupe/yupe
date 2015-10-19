<?php
$this->title = [Yii::t('UserModule.user', 'Sign in'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('UserModule.user', 'Sign in')];
?>
<div class="main__title grid">
    <h1 class="h2"><?= Yii::t('UserModule.user', 'Sign in'); ?></h1>
</div>
<div class="main__cart-box grid">
    <div class="grid-module-6">

        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', ['id' => 'login-form']); ?>

        <?= $form->errorSummary($model); ?>

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

        <?php if (Yii::app()->getModule('user')->sessionLifeTime > 0): { ?>
            <div class="fast-order__inputs">
                <?= $form->checkBox($model, 'remember_me'); ?>
                <?= $form->labelEx($model, 'remember_me'); ?>
            </div>
        <?php } endif; ?>

        <?php if (Yii::app()->getUser()->getState('badLoginCount', 0) >= 3 && CCaptcha::checkRequirements('gd')): { ?>
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
                <?= CHtml::submitButton(Yii::t('UserModule.user', 'Sign in'), [
                    'id' => 'login-btn',
                    'class' => 'btn btn_big btn_wide btn_white'
                ]) ?>
            </div>
            <div class="column grid-module-3 pull-right">
                <?= CHtml::link(
                    Yii::t('UserModule.user', 'Sign up'),
                    Yii::app()->createUrl('/user/account/registration'),
                    ['class' => 'btn btn_big btn_wide btn_white']
                ) ?>
            </div>
        </div>
        <div class="fast-order__inputs">
            <div class="grid-module-3">
                <?= CHtml::link(
                    Yii::t('UserModule.user', 'Forgot your password?'),
                    ['/user/account/recovery'],
                    ['class' => 'dropdown-menu__link']
                ) ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>