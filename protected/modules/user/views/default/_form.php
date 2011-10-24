<div class="form">

    <?php $form = $this->beginWidget('CActiveForm',array(
        'id' => 'add-user-form',
        'enableClientValidation' => true
    )); ?>

    <p class="note"><?php echo Yii::t('user', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>
    
    <div class="row">
        <?php echo $form->labelEx($model, 'nick_name'); ?>
        <?php echo $form->textField($model, 'nick_name', array('size' => 25, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'nick_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 25, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'last_name'); ?>
        <?php echo $form->textField($model, 'last_name', array('size' => 25, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'last_name'); ?>
    </div>    

    <div class="row">
        <?php echo $form->labelEx($model, 'first_name'); ?>
        <?php echo $form->textField($model, 'first_name', array('size' => 25, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'first_name'); ?>
    </div>    

    <div class="row">
        <?php echo $form->labelEx($model, 'gender'); ?>
        <?php echo $form->dropDownList($model, 'gender', $model->getGendersList()); ?>
        <?php echo $form->error($model, 'gender'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'access_level'); ?>
        <?php echo $form->dropDownList($model, 'access_level', $model->getAccessLevelsList()); ?>
        <?php echo $form->error($model, 'access_level'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('user', 'Сохранить')
                                           : Yii::t('user', 'Обновить')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->