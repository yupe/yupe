<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'recovery-password-form',
                                                         'enableAjaxValidation' => false,
                                                    )); ?>

    <p class="note"><?php echo Yii::t('user', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'userId'); ?>
        <?php echo $form->textField($model, 'userId'); ?>
        <?php echo $form->error($model, 'userId'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'code'); ?>
        <?php echo $form->textField($model, 'code', array('size' => 32, 'maxlength' => 32)); ?>
        <?php echo $form->error($model, 'code'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('user', 'Сохранить')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->