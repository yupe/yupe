<?php
$this->pageTitle = Yii::t('UserModule.user', 'Sign in');
$this->breadcrumbs = array(Yii::t('UserModule.user', 'Sign in'));
?>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'          => 'login-form',
        'type'        => 'vertical',
        'htmlOptions' => array(
            'class' => 'well',
        )
    )
); ?>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-xs-6">
        <?php echo $form->textFieldGroup($model, 'email'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-xs-6">
        <?php echo $form->passwordFieldGroup($model, 'password'); ?>
    </div>
</div>

<?php if ($this->getModule()->sessionLifeTime > 0): { ?>
    <div class='row'>
        <div class="col-xs-12">
            <?php echo $form->checkBoxGroup($model, 'remember_me'); ?>
        </div>
    </div>
<?php } endif; ?>

<?php if (Yii::app()->user->getState('badLoginCount', 0) >= 3 && CCaptcha::checkRequirements('gd')): { ?>
    <div class="row">
        <div class="col-xs-4">
            <?php echo $form->textFieldGroup(
                $model,
                'verifyCode',
                array('hint' => Yii::t('UserModule.user', 'Please enter the text from the image'))
            ); ?>
        </div>
        <div class="col-xs-4">
            <?php $this->widget(
                'CCaptcha',
                array(
                    'showRefreshButton' => true,
                    'imageOptions'      => array(
                        'width' => '150',
                    ),
                    'buttonOptions'     => array(
                        'class' => 'btn btn-default',
                    ),
                    'buttonLabel'       => '<i class="glyphicon glyphicon-repeat"></i>',
                )
            ); ?>
        </div>
    </div>
<?php } endif; ?>


<div class="row">
    <div class="col-xs-12">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType'  => 'submit',
                'context'     => 'primary',
                'icon'        => 'glyphicon glyphicon-signin',
                'label'       => Yii::t('UserModule.user', 'Sign in'),
                'htmlOptions' => array('id' => 'login-btn', 'name' => 'login-btn')
            )
        ); ?>

        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'link',
                'context'    => 'link',
                'label'      => Yii::t('UserModule.user', 'Sign up'),
                'url'        => Yii::app()->createUrl('/user/account/registration'),
            )
        ); ?>
    </div>
</div>

<hr/>

<?php if (Yii::app()->hasModule('social')): { ?>
    <div class="row">
        <div class="col-xs-12">
            <?php
            $this->widget(
                'vendor.nodge.yii-eauth.EAuthWidget',
                array(
                    'action'             => '/social/login',
                    'predefinedServices' => array('google', 'facebook', 'vkontakte', 'twitter', 'github'),
                )
            );
            ?>
        </div>
    </div>
<?php } endif; ?>
<div class="row">
    <div class="col-xs-12">
        <?php echo CHtml::link(Yii::t('UserModule.user', 'Forgot your password?'), array('/user/account/recovery')) ?>
    </div>
</div>

<?php $this->endWidget(); ?>
