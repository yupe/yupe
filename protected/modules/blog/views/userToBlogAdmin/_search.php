<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->dropDownList($model,'user_id',CHtml::listData(User::model()->findAll(),'id','nick_name')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'blog_id'); ?>
		<?php echo $form->dropDownList($model,'blog_id',CHtml::listData(Blog::model()->findAll(),'id','name')); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'role'); ?>
		<?php echo $form->dropDownList($model,'role',$model->getRoleList()); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',$model->getStatusList()); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'note'); ?>
		<?php echo $form->textField($model,'note',array('size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('blog','Найти')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->