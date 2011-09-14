<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'login-form',
                                                         'enableAjaxValidation' => false,
                                                    )); ?>

    <p class="note"><?php echo Yii::t('user', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'userId'); ?>
        <?php echo $form->textField($model, 'userId', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'userId'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'identityId'); ?>
        <?php echo $form->textField($model, 'identityId', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'identityId'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->textField($model, 'type', array('size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'creationDate'); ?>
        <?php echo $form->textField($model, 'creationDate'); ?>
        <?php echo $form->error($model, 'creationDate'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->