<div class="main__title grid">
    <h1 class="h2"><?= Yii::t('default', 'Finishing register'); ?></h1>
</div>
<div class="main__cart-box grid">
    <div class="grid-module-6">
        <?php $form = $this->beginWidget('CActiveForm', [
            'id' => 'registration-form',
            'enableClientValidation' => true
        ]); ?>

        <?= $form->errorSummary($model); ?>
        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'nick_name'); ?>
            <?= $form->textField($model, 'nick_name') ?>
            <?= $form->error($model, 'nick_name'); ?>
        </div>
        <div class="fast-order__inputs">
            <?= CHtml::submitButton(Yii::t('default', 'Register'), ['class' => 'btn btn_primary']); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
