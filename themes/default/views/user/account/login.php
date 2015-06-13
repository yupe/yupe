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
    <div class="col-xs-6">
        <?= $form->textFieldGroup($model, 'email'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-xs-6">
        <?= $form->passwordFieldGroup($model, 'password'); ?>
    </div>
</div>

<?php if ($this->getModule()->sessionLifeTime > 0): { ?>
    <div class='row'>
        <div class="col-xs-12">
            <?= $form->checkBoxGroup($model, 'remember_me'); ?>
        </div>
    </div>
<?php } endif; ?>

<?php if (Yii::app()->getUser()->getState('badLoginCount', 0) >= 3 && CCaptcha::checkRequirements('gd')): { ?>
    <div class="row">
        <div class="col-xs-4">
            <?= $form->textFieldGroup(
                $model,
                'verifyCode',
                ['hint' => Yii::t('UserModule.user', 'Please enter the text from the image')]
            ); ?>
        </div>
        <div class="col-xs-4">
            <?php $this->widget(
                'CCaptcha',
                [
                    'showRefreshButton' => true,
                    'imageOptions'      => [
                        'width' => '150',
                    ],
                    'buttonOptions'     => [
                        'class' => 'btn btn-default',
                    ],
                    'buttonLabel'       => '<i class="glyphicon glyphicon-repeat"></i>',
                ]
            ); ?>
        </div>
    </div>
<?php } endif; ?>


<div class="row">
    <div class="col-xs-12">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType'  => 'submit',
                'context'     => 'primary',
                'icon'        => 'glyphicon glyphicon-signin',
                'label'       => Yii::t('UserModule.user', 'Sign in'),
                'htmlOptions' => ['id' => 'login-btn', 'name' => 'login-btn']
            ]
        ); ?>

        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType' => 'link',
                'context'    => 'link',
                'label'      => Yii::t('UserModule.user', 'Sign up'),
                'url'        => Yii::app()->createUrl('/user/account/registration'),
            ]
        ); ?>
    </div>
</div>

<?php if (Yii::app()->hasModule('social')): { ?>
    <hr/>
    <div class="row">
        <div class="col-xs-12">
            <?php
            $this->widget(
                'vendor.nodge.yii-eauth.EAuthWidget',
                [
                    'action'             => '/social/login',
                    'predefinedServices' => ['google', 'facebook', 'vkontakte', 'twitter', 'github'],
                ]
            );
            ?>
        </div>
    </div>
<?php } endif; ?>
<div class="row">
    <div class="col-xs-12">
        <?= CHtml::link(Yii::t('UserModule.user', 'Forgot your password?'), ['/user/account/recovery']) ?>
    </div>
</div>

<?php $this->endWidget(); ?>
