<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
	'type'=>'vertical',
        'htmlOptions' => array('class' => 'well form-vertical')
)); ?>

<div class="alert alert-info"><?php echo Yii::t('yupe','Поля, отмеченные');?> <span class="required">*</span> <?php echo Yii::t('yupe','обязательны.');?></div>

	<?php echo  $form->errorSummary($model); ?>

	<div class='row-fluid control-group <?php echo $model->hasErrors("parent_id")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'parent_id',array('class'=>'span5','size' => 60,'maxlength' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("name")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150,'size' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("description")?"error":"" ?>'><?php echo  $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("alias")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'alias',array('class'=>'span5','maxlength'=>50,'size' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("status")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'status',array('class'=>'span5','size' => 60,'maxlength' => 60)); ?></div>

	
<?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=>$model->isNewRecord ? Yii::t('yupe','Создать категорию') : Yii::t('yupe','Сохранить категорию'),
)); ?>
	

<?php $this->endWidget(); ?>
