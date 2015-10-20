<?php
/**
 * @var CActiveForm $form
 */
$this->title = [Yii::t('UserModule.user', 'Password recovery'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('UserModule.user', 'Password recovery')];
?>
<div class="main__title grid">
    <h1 class="h2"><?= Yii::t('UserModule.user', 'Password recovery') ?></h1>
</div>
<div class="main__cart-box grid">
    <div class="grid-module-4">
        <?php $form = $this->beginWidget('CActiveForm', [
            'id' => 'recovery-form',
            'enableClientValidation' => true,
        ]); ?>

        <?= $form->errorSummary($model); ?>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'email'); ?>
            <?= $form->textField($model, 'email', [
                'class' => 'input input_big',
                'placeholder' => Yii::t('UserModule.user', 'Enter an email you have used during signup')
            ]); ?>
            <?= $form->error($model, 'email') ?>
        </div>
        <div class="fast-order__inputs">
            <div class="column grid-module-4">
                <?= CHtml::submitButton(Yii::t('UserModule.user', 'Recover password'), [
                    'class' => 'btn btn_big btn_wide btn_white'
                ]) ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>