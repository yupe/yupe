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
        <?php echo $form->labelEx($model, 'model_id'); ?>
        <?php echo $form->textField($model, 'model_id', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'model_id'); ?>
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
        <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
                                                      'model' => $model,
                                                      'attribute' => 'text',
                                                      'options'   => array(                                                           
                                                           'toolbar' => 'main',
                                                           'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/'                                                           
                                                       ),
                                                      'htmlOptions' => array('rows' => 20,'cols' => 6)
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