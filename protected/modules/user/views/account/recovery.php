<?php
/**
 * @var $this AccountController
 * @var $model RecoveryForm
 * @var $form TbActiveForm
 */

$this->title = Yii::t('UserModule.user', 'Password recovery.');
?>

<h1><?=  Yii::t('UserModule.user', 'Password recovery.'); ?></h1>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<p><?=  Yii::t('UserModule.user', 'For password recovery - select e-mail you used in registration form.'); ?></p>

<div class="form">
    <?php $form = $this->beginWidget(
        'CActiveForm',
        [
            'id'                     => 'recovery-password-form',
            'enableClientValidation' => true,
        ]
    ); ?>

    <?=  $form->errorSummary($model); ?>

    <div class="row">
        <?=  $form->labelEx($model, 'email'); ?>
        <?=  $form->textField($model, 'email'); ?>
        <?=  $form->error($model, 'email'); ?>
    </div>

    <div class="row submit">
        <?=  CHtml::submitButton(Yii::t('UserModule.user', 'Password recovery')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
