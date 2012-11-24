<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                   => 'mail-event-form',
    'enableAjaxValidation' => false,
    'htmlOptions'          => array('class' => 'well form-vertical'),
)); ?>

    <div class="alert alert-info">
        <?php echo Yii::t('comment', 'Поля, отмеченные'); ?> 
        <span class="required">*</span> 
        <?php echo Yii::t('comment', 'обязательны для заполнения'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class='control-group <?php echo $model->hasErrors("model") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'model', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>

    <div class='control-group <?php echo $model->hasErrors("model_id") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'model_id', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>

    <div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>

    <div class='control-group <?php echo $model->hasErrors("email") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'email', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>

   <div class='control-group <?php echo $model->hasErrors("url") ? "error" : ""; ?>'>
       <?php echo $form->textFieldRow($model, 'url', array('class' => 'span7', 'maxlength' => 300)); ?>
   </div>

   <div class='control-group <?php echo $model->hasErrors("text") ? "error" : "" ?>'>
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
              'model'       => $model,
              'attribute'   => 'text',
              'options'     => array(
                   'toolbar'     => 'main',
                   'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/',
               ),
              'htmlOptions' => array('rows' => 20, 'cols' => 6),
         )); ?>
    </div>

    <div class='control-group <?php echo $model->hasErrors("status") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList()); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('comment', 'Добавить комментарий и продолжить') : Yii::t('comment', 'Сохранить комментарий и продолжить'),
    )); ?>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
       'buttonType'  => 'submit',
       'htmlOptions' => array('name' => 'submit-type', 'value' => 'admin'),
       'label'       => $model->isNewRecord ? Yii::t('comment', 'Добавить комментарий и закрыть') : Yii::t('comment', 'Сохранить комментарий и закрыть'),
   )); ?>

<?php $this->endWidget(); ?>