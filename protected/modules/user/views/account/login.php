<?php $this->pageTitle = Yii::t('UserModule.user', 'Авторизация'); ?>

<?php Yii::app()->clientScript->registerScriptFile('http://connect.facebook.net/ru_RU/all.js'); ?>

<h1><?php echo Yii::t('UserModule.user', 'Авторизация'); ?></h1>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>

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
                    <?php echo Yii::t('UserModule.user', 'Введите текст указанный на картинке'); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <p class="hint">
            <?php echo CHtml::link(Yii::t('UserModule.user', "Регистрация"), array('/user/account/registration')); ?>
            | <?php echo CHtml::link(Yii::t('UserModule.user', "Восстановление пароля"), array('/user/account/recovery')); ?>
        </p>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton('Войти'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->

<?php  $this->widget('application.modules.social.extensions.eauth.EAuthWidget', array('action' => '/social/social/login')); ?>