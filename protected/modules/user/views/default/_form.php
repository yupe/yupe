<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'user-form',
                                                         'enableAjaxValidation' => false,
                                                    )); ?>

    <p class="note"><?php echo Yii::t('user', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>


    <div class="row">
        <?php echo $form->labelEx($model, 'firstName'); ?>
        <?php echo $form->textField($model, 'firstName', array('size' => 25, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'firstName'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'lastName'); ?>
        <?php echo $form->textField($model, 'lastName', array('size' => 25, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'lastName'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'nickName'); ?>
        <?php echo $form->textField($model, 'nickName', array('size' => 25, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'nickName'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 25, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('size' => 25, 'maxlength' => 30)); ?>
        <?php echo $form->error($model, 'password'); ?>
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
        <?php echo $form->labelEx($model, 'accessLevel'); ?>
        <?php echo $form->dropDownList($model, 'accessLevel', $model->getAccessLevelsList()); ?>
        <?php echo $form->error($model, 'accessLevel'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('user', 'Сохранить')
                                           : Yii::t('user', 'Обновить')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->