<?php
$this->layout = 'login';
$this->yupe->getComponent('bootstrap');
$this->pageTitle = Yii::t('UserModule.user', 'Authorization');
Yii::app()->getClientScript()->registerCssFile(
    Yii::app()->getAssetManager()->publish(
        Yii::getPathOfAlias('application.modules.user.views.assets') . '/css/backendlogin.css'
    )
);


?>
<div class="wrapper">
    <div class="login-form">
        <?php
        $form = $this->beginWidget(
            'bootstrap.widgets.TbActiveForm',
            [
                'id'          => 'horizontalForm',
                'htmlOptions' => ['class' => 'well']
            ]
        ); ?>
        <fieldset>
            <legend><?= Yii::t('UserModule.user', 'Authorize please'); ?></legend>
            <?= $form->errorSummary($model); ?>
            <div class='row'>
                <div class="col-xs-12">
                    <?= $form->textFieldGroup($model, 'email'); ?>
                </div>
                <div class="col-xs-12">
                    <?= $form->passwordFieldGroup($model, 'password'); ?>
                </div>
                <?php if ($this->getModule()->sessionLifeTime > 0): { ?>
                    <div class="col-xs-12">
                        <?= $form->checkBoxGroup($model, 'remember_me'); ?>
                    </div>
                <?php } endif; ?>

            </div>
            <?php if (Yii::app()->user->getState('badLoginCount', 0) >= $this->getModule()->badLoginCount): { ?>
                <div class='row'>
                    <div class="col-xs-12">
                        <?php if (CCaptcha::checkRequirements('gd')): { ?>
                            <div>
                                <?php $this->widget('CCaptcha', ['showRefreshButton' => true]); ?>
                                <?= $form->textFieldGroup(
                                    $model,
                                    'verifyCode',
                                    ['hint' => Yii::t('UserModule.user', 'Please enter the text from the image')]
                                ); ?>

                            </div>
                        <?php } endif; ?>
                    </div>
                </div>
            <?php } endif; ?>

            <?php if (!$this->getModule()->recoveryDisabled): { ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?= CHtml::link(
                            Yii::t('UserModule.user', 'Forgot password?'),
                            ['/user/account/recovery']
                        ); ?>
                    </div>
                </div>
            <?php } endif; ?>
        </fieldset>
        <div class="form-actions">
            <?php
            $this->widget(
                'bootstrap.widgets.TbButton',
                [
                    'buttonType'  => 'submit',
                    'context'     => 'primary',
                    'label'       => Yii::t('UserModule.user', 'Login'),
                    'htmlOptions' => [
                        'class' => 'btn-block'
                    ],
                ]
            );
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
