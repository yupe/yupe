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
    <div class="col-sm-6">
        <?php echo $form->textFieldGroup($model, 'email'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-6">
        <?php echo $form->passwordFieldGroup($model, 'password'); ?>
    </div>
</div>

<?php if (Yii::app()->getModule('user')->sessionLifeTime > 0): { ?>
    <div class='row'>
        <div class="col-sm-6">
            <?php echo $form->checkBoxGroup($model, 'remember_me'); ?>
        </div>
    </div>
<?php } endif; ?>

<?php if (Yii::app()->user->getState('badLoginCount', 0) >= 3 && CCaptcha::checkRequirements('gd')): { ?>
    <?php $this->widget(
        'CCaptcha',
        array(
            'showRefreshButton' => true,
            'imageOptions'      => array(
                'width' => '150',
            ),
            'buttonOptions'     => array(
                'class' => 'btn',
            ),
            'buttonLabel'       => '<i class="icon-repeat"></i>',
        )
    ); ?>

    <div class='row'>
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup(
                $model,
                'verifyCode',
                array('hint' => Yii::t('UserModule.user', 'Please enter the text from the image'))
            ); ?>
        </div>
    </div>
<?php } endif; ?>



<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context'    => 'primary',
        'icon'       => 'glyphicon glyphicon-ok',
        'label'      => Yii::t('UserModule.user', 'Sign in'),
    )
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'link',
        'label'      => Yii::t('UserModule.user', 'Sign up'),
        'url'        => Yii::app()->createUrl('/user/account/registration'),
    )
); ?>

<?php echo CHtml::link(Yii::t('UserModule.user', 'Forgot your password?'), array('/user/account/recovery')) ?>

<?php $this->endWidget(); ?>
