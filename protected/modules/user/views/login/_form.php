<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'login-form',
                                                         'enableAjaxValidation' => false,
                                                    )); ?>

    <p class="note"><?php echo Yii::t('user', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'user_id'); ?>
        <?php echo $form->textField($model, 'user_id', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'user_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'identity_id'); ?>
        <?php echo $form->textField($model, 'identity_id', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'identity_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->textField($model, 'type', array('size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'creation_date'); ?>
        <?php echo $form->textField($model, 'creation_date'); ?>
        <?php echo $form->error($model, 'creation_date'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create'
                                           : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->