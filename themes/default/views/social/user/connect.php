<?php
$this->title = [Yii::t('UserModule.user', 'Sign in'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('UserModule.user', 'Sign in')];
?>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'          => 'login-form',
        'type'        => 'vertical',
        'htmlOptions' => [
            'class' => 'well',
        ]
    ]
); ?>

<?= $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-6">
        <?= $form->textFieldGroup($model, 'email'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-6">
        <?= $form->passwordFieldGroup($model, 'password'); ?>
    </div>
</div>

<?php if (Yii::app()->getModule('user')->sessionLifeTime > 0): { ?>
    <div class='row'>
        <div class="col-sm-6">
            <?= $form->checkBoxGroup($model, 'remember_me'); ?>
        </div>
    </div>
<?php } endif; ?>

<?php if (Yii::app()->getUser()->getState('badLoginCount', 0) >= 3 && CCaptcha::checkRequirements('gd')): { ?>
    <?php $this->widget(
        'CCaptcha',
        [
            'showRefreshButton' => true,
            'imageOptions'      => [
                'width' => '150',
            ],
            'buttonOptions'     => [
                'class' => 'btn',
            ],
            'buttonLabel'       => '<i class="icon-repeat"></i>',
        ]
    ); ?>

    <div class='row'>
        <div class="col-sm-6">
            <?= $form->textFieldGroup(
                $model,
                'verifyCode',
                ['hint' => Yii::t('UserModule.user', 'Please enter the text from the image')]
            ); ?>
        </div>
    </div>
<?php } endif; ?>



<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'icon'       => 'glyphicon glyphicon-ok',
        'label'      => Yii::t('UserModule.user', 'Sign in'),
    ]
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'link',
        'label'      => Yii::t('UserModule.user', 'Sign up'),
        'url'        => Yii::app()->createUrl('/user/account/registration'),
    ]
); ?>

<?= CHtml::link(Yii::t('UserModule.user', 'Forgot your password?'), ['/user/account/recovery']) ?>

<?php $this->endWidget(); ?>
