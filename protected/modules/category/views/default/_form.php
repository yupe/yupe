<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<div class="alert alert-info">Поля, отмеченные звездочкой <span class="required">*</span> обязательны.</div>

	<?php echo  $form->errorSummary($model); ?>

	<div class='control-group <?php echo $model->hasErrors("parent_id")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'parent_id',array('class'=>'span5')); ?></div>

	<div class='control-group <?php echo $model->hasErrors("name")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150)); ?></div>

	<div class='control-group <?php echo $model->hasErrors("description")?"error":"" ?>'><?php echo  $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?></div>

	<div class='control-group <?php echo $model->hasErrors("alias")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'alias',array('class'=>'span5','maxlength'=>50)); ?></div>

	<div class='control-group <?php echo $model->hasErrors("status")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'status',array('class'=>'span5')); ?></div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
