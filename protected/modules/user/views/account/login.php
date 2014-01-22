<?php $this->pageTitle = Yii::t('UserModule.user', 'Authorization'); ?>

<?php Yii::app()->clientScript->registerScriptFile('http://connect.facebook.net/ru_RU/all.js'); ?>

<h1><?php echo Yii::t('UserModule.user', 'Authorization'); ?></h1>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
         'id'                     => 'login-form',
         'enableClientValidation' => true,
    ));?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email'); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password'); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <?php if($this->getModule()->sessionLifeTime > 0):  ?>
    <div class="row rememberMe">
        <?php echo $form->checkBox($model, 'remember_me'); ?>
        <?php echo $form->labelEx($model, 'remember_me'); ?>
        <?php echo $form->error($model, 'remember_me'); ?>
    </div>
    <?php endif; ?>
    <?php if (Yii::app()->user->getState('badLoginCount', 0) >= 3): ?>
        <div class='row'>
            <?php if (CCaptcha::checkRequirements('gd')): ?>
                <?php echo $form->labelEx($model, 'verifyCode'); ?>
                <div class='row-fluid'>
                    <?php $this->widget('CCaptcha', array('showRefreshButton' => true)); ?>
                </div>
                <div class='row-fluid'>
                    <?php echo $form->textField($model, 'verifyCode'); ?>
                    <?php echo $form->error($model, 'verifyCode'); ?>
                </div>
                <div class="hint">
                    <?php echo Yii::t('UserModule.user', 'Please enter the text from the image'); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <p class="hint">
            <?php if(!$this->getModule()->registrationDisabled):?>
                <?php echo CHtml::link(Yii::t('UserModule.user', 'Registration'), array('/user/account/registration')); ?>
            <?php endif;?>
            <?php if(!$this->getModule()->recoveryDisabled):?>
               | <?php echo CHtml::link(Yii::t('UserModule.user', 'Password recovery.'), array('/user/account/recovery')); ?>
            <?php endif;?>
        </p>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton('Login'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->

<?php  $this->widget('application.modules.social.extensions.eauth.EAuthWidget', array('action' => '/social/social/login')); ?>