<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'mail-event-form',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('class' => 'well form-vertical'),
)); ?>

<div class="alert alert-info"><?php echo Yii::t('mail','Поля, отмеченные');?> <span class="required">*</span> <?php echo Yii::t('mail','обязательны для заполнения');?></div>

    <?php echo  $form->errorSummary($model); ?>

    <div class='control-group <?php echo $model->hasErrors("code")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'code',array('class'=>'span7','maxlength'=>100)); ?></div>

    <div class='control-group <?php echo $model->hasErrors("name")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'name',array('class'=>'span7','maxlength'=>300)); ?></div>

    <div class='control-group <?php echo $model->hasErrors("description")?"error":"" ?>'>
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
              'model' => $model,
              'attribute' => 'description',
              'options'   => array(
                   'toolbar' => 'main',
                   'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/',
               ),
              'htmlOptions' => array('rows' => 20,'cols' => 6)
         )); ?>
        </div>

    
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>$model->isNewRecord ? Yii::t('mail','Добавить событие и продолжить') : Yii::t('mail','Сохранить событие и продолжить'),
        )); ?>
    
        <?php $this->widget('bootstrap.widgets.TbButton', array(
           'buttonType' => 'submit',
           'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
           'label'      => $model->isNewRecord ? Yii::t('mail', 'Добавить событие и закрыть') : Yii::t('mail', 'Сохранить событие и закрыть'),
       )); ?>
    

<?php $this->endWidget(); ?>
