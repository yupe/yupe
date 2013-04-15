<?php $this->pageTitle = Yii::t('UserModule.user', 'Регистрация новго пользователя'); ?>

<h1><?php echo Yii::t('UserModule.user', 'Регистрация нового пользователя'); ?></h1>

<div class='hint'><?php echo Yii::t('UserModule.user', 'Пожалуйста, имя пользователя и пароль заполняйте только латинскими буквами и цифрами.'); ?></div>

<br/><br/>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array('id' => 'registration-form')); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'nick_name'); ?>
        <?php echo $form->textField($model, 'nick_name'); ?>
        <?php echo $form->error($model, 'nick_name'); ?>
    </div>

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

    <div class="row">
        <?php echo $form->labelEx($model, 'cPassword'); ?>
        <?php echo $form->passwordField($model, 'cPassword'); ?>
        <?php echo $form->error($model, 'cPassword'); ?>
    </div>

    <?php if (Yii::app()->getModule('user')->showCaptcha): ?>
        <?php if (CCaptcha::checkRequirements('gd')): ?>
            <div class="row">
                <?php echo $form->labelEx($model, 'verifyCode'); ?>
                <div>
                    <?php $this->widget('CCaptcha', array('showRefreshButton' => false)); ?>
                    <?php echo $form->textField($model, 'verifyCode'); ?>
                    <?php echo $form->error($model, 'verifyCode'); ?>
                </div>
                <div class="hint">
                    <?php echo Yii::t('UserModule.user', 'Введите текст указанный на картинке'); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="row submit">
        <?php echo CHtml::submitButton('Зарегистрироваться'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->

<?php  $this->widget('application.modules.social.extensions.eauth.EAuthWidget', array('action' => '/social/social/login')); ?>

<div style='float:left;'>
    <div style='float:left;padding-right:5px'>
        <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
            'type'     => 'button',
            'services' => 'all',
        )); ?>
    </div>
</div>