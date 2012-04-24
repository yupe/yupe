<?php $this->pageTitle = Yii::t('user', 'Авторизация'); ?>

<?php Yii::app()->clientScript->registerScriptFile('http://connect.facebook.net/ru_RU/all.js'); ?>

<h1>Авторизация</h1>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'login-form',
                                                         'enableClientValidation' => true
                                                    ));?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email') ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password') ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row">
        <p class="hint">
            <?php echo CHtml::link(Yii::t('user', "Регистрация"), array('/user/account/registration')); ?>
            | <?php echo CHtml::link(Yii::t('user', "Восстановление пароля"), array('/user/account/recovery')) ?>
        </p>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton('Войти'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->

<?php  $this->widget('application.modules.social.extensions.eauth.EAuthWidget',array('action' => '/social/social/login/'));?>
