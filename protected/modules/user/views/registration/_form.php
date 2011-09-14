<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'registration-form',
                                                         'enableAjaxValidation' => false,
                                                    )); ?>

    <p class="note"><?php echo Yii::t('user', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>


    <div class="row">
        <?php echo $form->labelEx($model, 'nickName'); ?>
        <?php echo $form->textField($model, 'nickName', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'nickName'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('size' => 32, 'maxlength' => 32)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('user', 'Создать')
                                           : Yii::t('user', 'Обновить')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->