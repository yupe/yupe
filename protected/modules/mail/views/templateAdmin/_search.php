<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo  $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo  $form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo  $form->textFieldRow($model,'event_id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo  $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>300)); ?>

	<?php echo  $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo  $form->textFieldRow($model,'from',array('class'=>'span5','maxlength'=>300)); ?>

	<?php echo  $form->textFieldRow($model,'to',array('class'=>'span5','maxlength'=>300)); ?>

	<?php echo  $form->textAreaRow($model,'theme',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo  $form->textAreaRow($model,'body',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo  $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'primary',
			'label'=>Yii::t('yupe','Искать'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
