<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'feed-back-form'
                                                    )); ?>

    <p class="note"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>


    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->dropDownList($model, 'type', Yii::app()->getModule('feedback')->types); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'theme'); ?>
        <?php echo $form->textField($model, 'theme', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'theme'); ?>
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

    <?php if($model->status == FeedBack::STATUS_ANSWER_SENDED):?>

    <div class="row">
        <label><?php echo Yii::t('feedback','Ответ');?></label>
        <?php echo $model->answer;?>
    </div>

    <?php endif;?>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('feedback', 'Добавить сообщение')
                                           : Yii::t('feedback', 'Сохранить изменения')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->