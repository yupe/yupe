<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'mail-event-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

<div class="alert alert-info"><?php echo Yii::t('yupe','Поля, отмеченные');?> <span class="required">*</span> <?php echo Yii::t('yupe','обязательны.');?></div>

	<?php echo  $form->errorSummary($model); ?>

	<div class='control-group <?php echo $model->hasErrors("code")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>100)); ?></div>

	<div class='control-group <?php echo $model->hasErrors("name")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>300)); ?></div>

	<div class='control-group <?php echo $model->hasErrors("description")?"error":"" ?>'>
              <?php echo $form->labelEx($model, 'description'); ?>
              <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
                                                      'model' => $model,
                                                      'attribute' => 'description',
                                                      'options'   => array(                                                           
                                                           'toolbar' => 'main',
                                                           'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/'                                                           
                                                       ),
                                                      'htmlOptions' => array('rows' => 20,'cols' => 6)
                                                 ))?>
        </div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('yupe','Создать') : 'Сохранить',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
