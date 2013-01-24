<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
         'id'                   => 'vote-form',
         'enableAjaxValidation' => false,
    )); ?>

    <p class="note"><?php echo Yii::t('VoteModule.vote', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'model'); ?>
        <?php echo $form->textField($model, 'model', array('size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'model'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'model_id'); ?>
        <?php echo $form->textField($model, 'model_id', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'model_id'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'value'); ?>
        <?php echo $form->textField($model, 'value'); ?>
        <?php echo $form->error($model, 'value'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('VoteModule.vote', 'Добавить голос') : Yii::t('VoteModule.vote', 'Сохранить голос')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->