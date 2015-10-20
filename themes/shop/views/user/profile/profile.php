<?php
/**
 * @var CActiveForm $form
 */
$this->title = [Yii::t('UserModule.user', 'User profile'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('UserModule.user', 'User profile')];
?>
<div class="main__title grid">
    <h1 class="h2"><?= Yii::t('UserModule.user', 'User profile') ?></h1>
</div>
<div class="main__cart-box grid">
    <div class="grid-module-6">
        <?php $form = $this->beginWidget('CActiveForm', [
            'id' => 'profile-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions' => [
                'enctype' => 'multipart/form-data',
            ]
        ]); ?>

        <?= $form->errorSummary($model); ?>

        <div class="fast-order__inputs">
            <div class="column grid-module-3">
                <?php $this->widget('AvatarWidget',
                    ['user' => $user, 'noCache' => true, 'imageHtmlOptions' => ['width' => 100, 'height' => 100]]); ?>
            </div>
            <div class=" column grid-module-3">
                <?= $form->checkBox($model, 'use_gravatar'); ?>
                <?= $form->labelEx($model, 'use_gravatar'); ?>

                <?= $form->fileField($model, 'avatar', [
                    'style' => 'background: inherit;'
                ]); ?>
            </div>
        </div>

        <div class="fast-order__inputs">
            <div class=" column grid-module-4">
                <?= $form->textField($user, 'email', [
                    'disabled' => true,
                    'class' => Yii::app()->getUser()->profile->getIsVerifyEmail() ? 'input input_big success' : 'input input_big',
                ]); ?>
                <?php if (Yii::app()->getUser()->profile->getIsVerifyEmail()): { ?>
                    <p class="email-status-confirmed text-success">
                        <?= Yii::t('UserModule.user', 'E-mail was verified'); ?>
                    </p>
                <?php } else: { ?>
                    <p class="email-status-not-confirmed text-error">
                        <?= Yii::t('UserModule.user', 'e-mail was not confirmed, please check you mail!'); ?>
                    </p>
                <?php } endif ?>
            </div>
            <div class="column grid-module-2 pull-right">
                <?= CHtml::link(Yii::t('UserModule.user', 'Change email'), ['/user/profile/email'],
                    ['class' => 'btn btn_big btn_wide btn_white']) ?>
            </div>
        </div>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'last_name'); ?>
            <?= $form->textField($model, 'last_name', ['class' => 'input input_big']); ?>
            <?= $form->error($model, 'last_name') ?>
        </div>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'first_name'); ?>
            <?= $form->textField($model, 'first_name', ['class' => 'input input_big']); ?>
            <?= $form->error($model, 'first_name') ?>
        </div>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'middle_name'); ?>
            <?= $form->textField($model, 'middle_name', ['class' => 'input input_big']); ?>
            <?= $form->error($model, 'middle_name') ?>
        </div>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'gender'); ?>
            <?= $form->dropDownList($model, 'gender', User::model()->getGendersList(), [
                'data-original-title' => $model->getAttributeLabel('gender'),
                'data-content' => User::model()->getAttributeDescription('gender'),
                'class' => 'input input_big'
            ]); ?>
        </div>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'birth_date'); ?>
            <?= $form->dateField($model, 'birth_date', ['class' => 'input input_big']) ?>
            <?= $form->error($model, 'birth_date') ?>
        </div>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'location'); ?>
            <?= $form->textField($model, 'location', ['class' => 'input input_big']); ?>
            <?= $form->error($model, 'location') ?>
        </div>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'site'); ?>
            <?= $form->textField($model, 'site', ['class' => 'input input_big']); ?>
            <?= $form->error($model, 'site') ?>
        </div>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'about'); ?>
            <?= $form->textArea($model, 'about', [
                'rows' => 7,
                'class' => 'input input_big'
            ]); ?>
            <?= $form->error($model, 'about') ?>
        </div>

        <div class="fast-order__inputs">
            <?php if (is_array($this->module->profiles) && count($this->module->profiles)): { ?>
                <?php foreach ($this->module->profiles as $k => $p): { ?>
                    <?php $this->renderPartial("//" . $k . "/" . $k . "_profile",
                        ["model" => $p, "form" => $form]); ?>
                <?php } endforeach; ?>
            <?php } endif; ?>
        </div>

        <div class="fast-order__inputs">
            <div class="column grid-module-3">
                <?= CHtml::submitButton(Yii::t('UserModule.user', 'Save profile'), [
                    'class' => 'btn btn_big btn_wide btn_white'
                ]) ?>
            </div>
            <div class="column grid-module-3 pull-right">
                <?= CHtml::link(Yii::t('UserModule.user', 'Change password'), ['/user/profile/password'], [
                    'class' => 'btn btn_big btn_wide btn_white'
                ]) ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>