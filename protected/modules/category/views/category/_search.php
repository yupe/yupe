<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo  $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo  $form->textFieldRow($model,'parent_id',array('class'=>'span5')); ?>

	<?php echo  $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150)); ?>

	<?php echo  $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo  $form->textFieldRow($model,'alias',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo  $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
                                        'type'=>'primary',
                                        'encodeLabel' => false,
                                        'label'=>'<i class="icon-search icon-white"></i> '.Yii::t('yupe','Искать'),
                                )); ?>
	</div>

<?php $this->endWidget(); ?>
