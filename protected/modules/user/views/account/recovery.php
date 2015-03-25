<?php
/**
 * @var $this AccountController
 * @var $model RecoveryForm
 * @var $form TbActiveForm
 */

$this->title = Yii::t('UserModule.user', 'Password recovery.');
?>

<h1><?php echo Yii::t('UserModule.user', 'Password recovery.'); ?></h1>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<p><?php echo Yii::t('UserModule.user', 'For password recovery - select e-mail you used in registration form.'); ?></p>

<div class="form">
    <?php $form = $this->beginWidget(
        'CActiveForm',
        [
            'id'                     => 'recovery-password-form',
            'enableClientValidation' => true,
        ]
    ); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email'); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton(Yii::t('UserModule.user', 'Password recovery')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
