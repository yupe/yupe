<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'gallery-form',
	'enableAjaxValidation' =>false,
	'enableClientValidation' =>true,
	'type'=>'vertical',
        'htmlOptions' => array('class' => 'well form-vertical')
)); ?>

<div class="alert alert-info"><?php echo Yii::t('gallery','Поля, отмеченные');?> <span class="required">*</span> <?php echo Yii::t('gallery','обязательны.');?></div>

	<?php echo  $form->errorSummary($model); ?>

	<div class='row-fluid control-group <?php echo $model->hasErrors("name")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>300,'size' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("description")?"error":"" ?>'><?php echo  $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("status")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'status',array('class'=>'span5','size' => 60,'maxlength' => 60)); ?></div>

	
<?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=>$model->isNewRecord ? Yii::t('gallery','Добавить Галерею') : Yii::t('gallery','Сохранить Галерею'),
)); ?>
	

<?php $this->endWidget(); ?>
