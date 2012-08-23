<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'contest-form',
                                                         'enableAjaxValidation' => false,
                                                    )); ?>

    <p class="note"><?php echo Yii::t('contentblock', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('cols' => 65, 'rows' => 7)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'start_add_image'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                                   'model' => $model,
                                                                   'attribute' => 'start_add_image',
                                                                   'options' => array(
                                                                       'dateFormat' => 'yy-mm-dd',
                                                                   ),
                                                              )); ?>
        <?php echo $form->error($model, 'start_add_image'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'stop_add_image'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                                   'model' => $model,
                                                                   'attribute' => 'stop_add_image',
                                                                   'options' => array(
                                                                       'dateFormat' => 'yy-mm-dd',
                                                                   ),
                                                              )); ?>
        <?php echo $form->error($model, 'stop_add_image'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'start_vote'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                                   'model' => $model,
                                                                   'attribute' => 'start_vote',
                                                                   'options' => array(
                                                                       'dateFormat' => 'yy-mm-dd',
                                                                   ),
                                                              )); ?>
        <?php echo $form->error($model, 'start_vote'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'stop_vote'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                                   'model' => $model,
                                                                   'attribute' => 'stop_vote',
                                                                   'options' => array(
                                                                       'dateFormat' => 'yy-mm-dd',
                                                                   ),
                                                              )); ?>
        <?php echo $form->error($model, 'stop_vote'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('contest', 'Добавить конкурс')
                                           : Yii::t('contest', 'Сохранить изменения')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->