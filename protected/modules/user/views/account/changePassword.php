<?php
/**
 * @var $this AccountController
 * @var $model ChangePasswordForm
 * @var $form TbActiveForm
 */

$this->title = Yii::t('UserModule.user', 'Changing password');
?>

<h1><?php echo Yii::t('UserModule.user', 'Password recovery.'); ?></h1>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>


<p><?php echo Yii::t('UserModule.user', 'Choose new password'); ?></p>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm'); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'cPassword'); ?>
        <?php echo $form->passwordField($model, 'cPassword'); ?>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton(Yii::t('UserModule.user', 'Change password')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
