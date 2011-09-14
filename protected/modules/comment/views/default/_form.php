<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'comment-form',
                                                         'enableAjaxValidation' => false,
                                                    )); ?>

    <p class="note"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'model'); ?>
        <?php echo $form->textField($model, 'model', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'model'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'modelId'); ?>
        <?php echo $form->textField($model, 'modelId', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'modelId'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'url'); ?>
        <?php echo $form->textField($model, 'url', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'url'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php $this->widget('application.widgets.EMarkItUp.EMarkitupWidget', array(
                                                                                  'model' => $model,
                                                                                  'attribute' => 'text',
                                                                                  'htmlOptions' => array('rows' => 16, 'cols' => 50)
                                                                             ))?>
        <?php echo $form->error($model, 'text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'ip'); ?>
        <?php echo $model->ip; ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('comment', 'Добавить комментарий')
                                           : Yii::t('comment', 'Сохранить комментарий')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->