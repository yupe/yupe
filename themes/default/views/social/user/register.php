<?php

/* @var $model RegistrationForm */

$this->title = Yii::t('UserModule.user', 'Sign up');
$this->breadcrumbs = [Yii::t('UserModule.user', 'Sign up')];
?>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'           => 'social-registration-form',
        'type'         => 'vertical',
        'htmlOptions'  => [
            'class' => 'well',
        ]
    ]
); ?>

<?= $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-6">
        <?= $form->textFieldGroup($model, 'nick_name'); ?>
    </div>
</div>

<?php if (!$model->email): ?>
    <div class='row'>
        <div class="col-sm-6">
            <?= $form->textFieldGroup($model, 'email'); ?>
        </div>
    </div>
<?php endif; ?>


<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => Yii::t('UserModule.user', 'Sign up'),
    ]
); ?>

<?php $this->endWidget(); ?>
<!-- form -->
