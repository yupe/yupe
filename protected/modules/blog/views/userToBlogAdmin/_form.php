<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-to-blog-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->dropDownList($model,'user_id',CHtml::listData(User::model()->findAll(),'id','nick_name')); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'blog_id'); ?>
		<?php echo $form->dropDownList($model,'blog_id',CHtml::listData(Blog::model()->findAll(),'id','name')); ?>
		<?php echo $form->error($model,'blog_id'); ?>
	</div>	

	<div class="row">
		<?php echo $form->labelEx($model,'role'); ?>
		<?php echo $form->dropDownList($model,'role',$model->getRoleList()); ?>
		<?php echo $form->error($model,'role'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',$model->getStatusList()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textField($model,'note',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('blog','Добавить участника') : Yii::t('blog','Сохранить')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->