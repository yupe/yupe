<?php
$this->title = Yii::t('UserModule.user', 'Password recovery');
$this->breadcrumbs = [Yii::t('UserModule.user', 'Password recovery')];
?>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>
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
            <?= $form->labelEx($model, 'password'); ?>
            <?= $form->passwordField($model, 'password', [
                'class' => 'input input_big',
            ]); ?>
            <?= $form->error($model, 'password') ?>
        </div>
        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'cPassword'); ?>
            <?= $form->passwordField($model, 'cPassword', [
                'class' => 'input input_big',
            ]); ?>
            <?= $form->error($model, 'cPassword') ?>
        </div>
        <div class="fast-order__inputs">
            <div class="column grid-module-4">
                <?= CHtml::submitButton(Yii::t('UserModule.user', 'Change password'), [
                    'class' => 'btn btn_big btn_wide btn_white'
                ]) ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
