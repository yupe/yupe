<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contest-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('contentblock','Поля, отмеченные * обязательны для заполнения')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('cols'=>65,'rows'=>7)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'startAddImage'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'    => $model,
			'attribute'=>'startAddImage',			
			'options'=>array(
				'dateFormat'=>'yy-mm-dd',
			),			
		)); ?>
		<?php echo $form->error($model,'startAddImage'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stopAddImage'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute'=>'stopAddImage',			
			'options'=>array(
				'dateFormat'=>'yy-mm-dd',
			),			
		)); ?>
		<?php echo $form->error($model,'stopAddImage'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'startVote'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute'=>'startVote',			
			'options'=>array(
				'dateFormat'=>'yy-mm-dd',
			),			
		)); ?>
		<?php echo $form->error($model,'startVote'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stopVote'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute'=>'stopVote',			
			'options'=>array(
				'dateFormat'=>'yy-mm-dd',
			),			
		)); ?>
		<?php echo $form->error($model,'stopVote'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',$model->getStatusList()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('contest','Добавить конкурс') : Yii::t('contest','Сохранить изменения')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->