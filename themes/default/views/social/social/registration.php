<h1>
    <?= Yii::t('default', 'Finishing register'); ?>
</h1>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<div class="form">

    <?php $form = $this->beginWidget(
        'CActiveForm',
        [
            'id'                     => 'registration-form',
            'enableClientValidation' => true
        ]
    );?>

    <?= $form->errorSummary($model); ?>
    <div class="row">
        <?= $form->labelEx($model, 'nick_name'); ?>
        <?= $form->textField($model, 'nick_name') ?>
        <?= $form->error($model, 'nick_name'); ?>
    </div>
    <div class="row submit">
        <?= CHtml::submitButton(Yii::t('default', 'Register')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
