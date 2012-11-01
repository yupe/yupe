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
        <?php echo $form->labelEx($model, 'location'); ?>
        <?php echo $form->textField($model, 'location', array('size' => 25, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'location'); ?>
    </div>    

    <div class="row">
        <?php echo $form->labelEx($model, 'site'); ?>
        <?php echo $form->textField($model, 'site', array('size' => 25, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'site'); ?>
    </div>    

    <div class="row">
        <?php echo $form->labelEx($model, 'birth_date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'=>$model,            
            'attribute' => 'birth_date',
            'options'   => array(
                'dateFormat' => 'yy-mm-dd'
             )          
        )); ?>
        <?php echo $form->error($model, 'birth_date'); ?>
    </div>    

    <div class="row">
        <?php echo $form->labelEx($model, 'about'); ?>
        <?php echo $form->textArea($model, 'about', array('rows' => 7, 'cols' => 45)); ?>
        <?php echo $form->error($model, 'about'); ?>
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

    <div class="row">
        <?php echo $form->labelEx($model, 'email_confirm'); ?>
        <?php echo $form->dropDownList($model, 'email_confirm', $model->getEmailConfirmStatusList()); ?>
        <?php echo $form->error($model, 'email_confirm'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('user', 'Сохранить пользователя')
                                           : Yii::t('user', 'Обновить данные пользователя')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->