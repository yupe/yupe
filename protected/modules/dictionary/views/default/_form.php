<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'dictionary-group-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('dictionary','Поля, отмеченные');?> <span class="required">*</span> <?php echo Yii::t('dictionary','обязательны для заполнения');?>.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>45,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>	

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>	

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>7,'cols'=>60)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('dictionary','Добавить группу') : Yii::t('dictionary','Сохранить')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->