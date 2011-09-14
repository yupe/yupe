<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'profile-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('user','Поля, отмеченные * обязательны для заполнения')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">		
		<?php echo $form->hiddenField($model,'userId'); ?>		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'twitter'); ?>
		<?php echo $form->textField($model,'twitter',array('size'=>25,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'twitter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'livejournal'); ?>
		<?php echo $form->textField($model,'livejournal',array('size'=>25,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'livejournal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vkontakte'); ?>
		<?php echo $form->textField($model,'vkontakte',array('size'=>25,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'vkontakte'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'odnoklassniki'); ?>
		<?php echo $form->textField($model,'odnoklassniki',array('size'=>25,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'odnoklassniki'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'facebook'); ?>
		<?php echo $form->textField($model,'facebook',array('size'=>25,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'facebook'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'yandex'); ?>
		<?php echo $form->textField($model,'yandex',array('size'=>25,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'yandex'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'google'); ?>
		<?php echo $form->textField($model,'google',array('size'=>25,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'google'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'blog'); ?>
		<?php echo $form->textField($model,'blog',array('size'=>25,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'blog'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'site'); ?>
		<?php echo $form->textField($model,'site',array('size'=>25,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'site'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'about'); ?>
		<?php echo $form->textArea($model,'about',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'about'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>25,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'location'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>25,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('user','Добавить') : Yii::t('user','Сохранить')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->