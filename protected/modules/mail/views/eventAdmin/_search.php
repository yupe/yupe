<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo  $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo  $form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo  $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>300)); ?>

	<?php echo  $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<button class="btn btn-primary" type="submit" name="yt0"><i class="icon-search icon-white"></i> Искать</button>
	</div>

<?php $this->endWidget(); ?>
