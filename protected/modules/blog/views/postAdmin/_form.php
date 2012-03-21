<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'post-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'blog_id'); ?>
		<?php echo $form->dropDownList($model,'blog_id',CHtml::listData(Blog::model()->findAll(),'id','name'),array('empty' => Yii::t('blog','выберите блог'))); ?>
		<?php echo $form->error($model,'blog_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>	

	<div class="row">
		<?php echo $form->labelEx($model,'slug'); ?>
		<?php echo Yii::t('blog', 'Оставьте пустым для автоматической генерации'); ?>
		<?php echo $form->textField($model,'slug',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'slug'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'publish_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                                   'model' => $model,
                                                                   'attribute' => 'publish_date',
                                                                   'options' => array(
                                                                       'dateFormat' => 'yy-mm-dd',
                                                                   ),
                                                              )); ?>
		<?php echo $form->error($model,'publish_date'); ?>
	</div>		

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php $this->widget('application.modules.yupe.widgets.EMarkItUp.EMarkitupWidget', array(
                                                                                  'model' => $model,
                                                                                  'attribute' => 'content',
                                                                                  'htmlOptions' => array('rows' => 16, 'cols' => 50)
                                                                             ))?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quote'); ?>
		<?php $this->widget('application.modules.yupe.widgets.EMarkItUp.EMarkitupWidget', array(
                                                                                  'model' => $model,
                                                                                  'attribute' => 'quote',
                                                                                  'htmlOptions' => array('rows' => 16, 'cols' => 50)
                                                                             ))?>
		<?php echo $form->error($model,'quote'); ?>
	</div>

	<div class='row'>
        <?php echo $form->labelEx($model,Yii::t('blog','Теги')); ?>
		<?php echo CHtml::textField('tags',$model->tags->toString(),array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'tags'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',$model->getStatusList()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment_status'); ?>
		<?php echo $form->checkBox($model,'comment_status'); ?>
		<?php echo $form->error($model,'comment_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'access_type'); ?>
		<?php echo $form->dropDownList($model,'access_type',$model->getAccessTypeList()); ?>
		<?php echo $form->error($model,'access_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'keywords'); ?>
		<?php echo $form->textField($model,'keywords',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'keywords'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>10,'cols'=>65)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('blog','Добавить запись') : Yii::t('blog','Сохранить запись')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->