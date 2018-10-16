<?php
/**
 * @var $this AccountController
 * @var $model ChangePasswordForm
 * @var $form TbActiveForm
 */

$this->title = Yii::t('UserModule.user', 'Changing password');
?>

<h1><?=  Yii::t('UserModule.user', 'Password recovery.'); ?></h1>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>


<p><?=  Yii::t('UserModule.user', 'Choose new password'); ?></p>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm'); ?>

    <?=  $form->errorSummary($model); ?>

    <div class="row">
        <?=  $form->labelEx($model, 'password'); ?>
        <?=  $form->passwordField($model, 'password'); ?>
    </div>

    <div class="row">
        <?=  $form->labelEx($model, 'cPassword'); ?>
        <?=  $form->passwordField($model, 'cPassword'); ?>
    </div>

    <div class="row submit">
        <?=  CHtml::submitButton(Yii::t('UserModule.user', 'Change password')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
