   <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'content-block-form',
                                                         'enableAjaxValidation' => false,
                                                         'htmlOptions'=> array ("class"=> "well")
                                                    )); ?>

    <p class="note"><?php echo Yii::t('contentblock', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->dropDownList($model, 'type', $model->getTypes()); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'code'); ?>
        <?php echo $form->textField($model, 'code', array('size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'code'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php $this->widget('application.modules.yupe.widgets.EMarkItUp.EMarkitupWidget', array(
                                                                                  'model' => $model,
                                                                                  'attribute' => 'content',
                                                                                  'htmlOptions' => array('rows' => 16, 'cols' => 50)
                                                                             ))?>
        <?php echo $form->error($model, 'content'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget('application.modules.yupe.widgets.EMarkItUp.EMarkitupWidget', array(
                                                                                  'model' => $model,
                                                                                  'attribute' => 'description',
                                                                                  'htmlOptions' => array('rows' => 16, 'cols' => 50)
                                                                             ))?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('contentblock', 'Добавить блок')
                                           : Yii::t('contentblock', 'Сохранить изменения')); ?>
    </div>

    <?php $this->endWidget(); ?>
