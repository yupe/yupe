<?php
$this->title = [Yii::t('UserModule.user', 'Sign up'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('UserModule.user', 'Sign up')];
?>

<div class="main__title grid">
    <h1 class="h2"><?= Yii::t('UserModule.user', 'Sign in'); ?></h1>
</div>
<div class="main__cart-box grid">
    <div class="grid-module-6">

        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', ['id' => 'social-registration-form']); ?>

        <?= $form->errorSummary($model); ?>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'nick_name'); ?>
            <?= $form->textField($model, 'nick_name', ['class' => 'input input_big']); ?>
            <?= $form->error($model, 'nick_name') ?>
        </div>

        <?php if (!isset($authData['email'])): { ?>
            <div class="fast-order__inputs">
                <?= $form->labelEx($model, 'email'); ?>
                <?= $form->textField($model, 'email', ['class' => 'input input_big']); ?>
                <?= $form->error($model, 'email') ?>
            </div>
        <?php } endif; ?>

        <div class="fast-order__inputs">
            <div class="column grid-module-3">
                <?= CHtml::submitButton(Yii::t('UserModule.user', 'Sign up'), [
                    'id' => 'login-btn',
                    'class' => 'btn btn_big btn_wide btn_white'
                ]) ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
