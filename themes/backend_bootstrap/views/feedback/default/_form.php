    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'feed-back-form'
                                                    )); ?>
    <fieldset class="inline">
        <div class="alert alert-info"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></div>

        <?php echo $form->errorSummary($model); ?>


        <div class="row-fluid control-group  <?php echo $model-> hasErrors('type')?'error':'' ?>">
            <div class="span7">
                <?php echo $form->labelEx($model, 'type'); ?>
                <?php echo $form->dropDownList($model, 'type', Yii::app()->getModule('feedback')->types); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'type'); ?>
            </div>
        </div>

        <div class="row-fluid control-group  <?php echo $model-> hasErrors('name')?'error':'' ?>">
            <div class="span7">
                <?php echo $form->labelEx($model, 'name'); ?>
                <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 100)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>

        <div class="row-fluid control-group  <?php echo $model-> hasErrors('email')?'error':'' ?>">
            <div class="span7">
                <?php echo $form->labelEx($model, 'email'); ?>
                <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 100)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>

        <div class="row-fluid control-group  <?php echo $model-> hasErrors('theme')?'error':'' ?>">
            <div class="span7">
                <?php echo $form->labelEx($model, 'theme'); ?>
                <?php echo $form->textField($model, 'theme', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'theme'); ?>
            </div>
        </div>

        <div class="row-fluid control-group  <?php echo $model-> hasErrors('text')?'error':'' ?>">
            <div class="span7">
                <?php echo $form->labelEx($model, 'text'); ?>
                <?php echo $form->textArea($model, 'text', array('rows' => 7, 'cols' => 65)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'text'); ?>
            </div>
        </div>

        <div class="row-fluid control-group  <?php echo $model-> hasErrors('status')?'error':'' ?>">
            <div class="span7">
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>

            <?php echo CHtml::submitButton($model->isNewRecord
                                               ? Yii::t('feedback', 'Добавить сообщение')
                                               : Yii::t('feedback', 'Сохранить изменения'),
                                               array('class' => 'btn btn-primary',)); ?>
    </fieldset>
    <?php $this->endWidget(); ?>