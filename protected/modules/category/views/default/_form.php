<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'category-form',
                                                         'enableAjaxValidation' => false,
                                                    )); ?>

    <p class="note"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'parentId'); ?>
        <?php echo $form->dropDownList($model, 'parentId', $categoryes); ?>
        <?php echo $form->error($model, 'parentId'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'alias'); ?>
        <?php echo $form->textField($model, 'alias', array('size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'alias'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget('application.widgets.EMarkItUp.EMarkitupWidget', array(
                                                                                  'model' => $model,
                                                                                  'attribute' => 'description',
                                                                                  'htmlOptions' => array('rows' => 16, 'cols' => 50)
                                                                             ))?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('category', 'Добавить категорию')
                                               : Yii::t('category', 'Сохранить измнения')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->