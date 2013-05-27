<?php
$this->pageTitle = Yii::t('user', 'Авторизация');
$this->breadcrumbs = array('Авторизация');
?>

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
            <?php echo CHtml::link(Yii::t('user', "Регистрация"), array('/user/account/registration')); ?>
            | <?php echo CHtml::link(Yii::t('user', "Восстановление пароля"), array('/user/account/recovery')) ?>
        </p>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton('Войти'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->