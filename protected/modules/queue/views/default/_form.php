<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'queue-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<div class="alert alert-info">Поля, отмеченные звездочкой <span class="required">*</span> обязательны.</div>

	<?php echo $form->errorSummary($model); ?>

	<div class='control-group <?=$model->hasErrors("worker")?"error":"" ?>'><?php echo $form->textFieldRow($model,'worker',array('class'=>'span5','maxlength'=>300)); ?></div>

	<div class='control-group <?=$model->hasErrors("task")?"error":"" ?>'><?php echo $form->textAreaRow($model,'task',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?></div>
	
	<div class='control-group <?=$model->hasErrors("notice")?"error":"" ?>'><?php echo $form->textFieldRow($model,'notice',array('class'=>'span5','maxlength'=>300)); ?></div>

    <div class='control-group <?=$model->hasErrors("status")?"error":"" ?>'><?php echo $form->dropDownListRow($model,'status',$model->getStatusList(),array('class'=>'span5')); ?></div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
