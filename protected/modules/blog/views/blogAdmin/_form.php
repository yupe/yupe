<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'blog-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
)); ?>

	<p class="note"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'slug'); ?>
		<?php echo $form->textField($model,'slug',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'slug'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'icon'); ?>
		<?php echo $form->textField($model,'icon',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'icon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php $this->widget('application.modules.yupe.widgets.EMarkItUp.EMarkitupWidget', array(
                                                                                  'model' => $model,
                                                                                  'attribute' => 'description',
                                                                                  'htmlOptions' => array('rows' => 16, 'cols' => 50)
                                                                             ))?>
		<?php echo $form->error($model,'description'); ?>
	</div>	

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',$model->getTypeList()); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',$model->getStatusList()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('blog','Добавить блог') : Yii::t('blog','Сохранить')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->