<h1>
    <?php echo Yii::t('default', 'Finishing register'); ?>
</h1>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<div class="form">

    <?php $form = $this->beginWidget(
        'CActiveForm',
        array(
            'id'                     => 'registration-form',
            'enableClientValidation' => true
        )
    );?>

    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'nick_name'); ?>
        <?php echo $form->textField($model, 'nick_name') ?>
        <?php echo $form->error($model, 'nick_name'); ?>
    </div>
    <div class="row submit">
        <?php echo CHtml::submitButton(Yii::t('default', 'Register')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
