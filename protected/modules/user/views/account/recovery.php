<?php $this->pageTitle = Yii::t('UserModule.user', 'Восстановление пароля'); ?>

<h1><?php echo Yii::t('UserModule.user', 'Восстановление пароля'); ?></h1>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>

<p><?php echo Yii::t('UserModule.user', 'Для восстановления пароля - введите email, указанный при регистрации.'); ?></p>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
         'id'                     => 'recovery-password-form',
         'enableClientValidation' => true,
    )); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email'); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton(Yii::t('UserModule.user', 'Восстановить пароль')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->