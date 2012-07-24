<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'good-form',
	'enableAjaxValidation'=>false,
	'type'=>'vertical',
        'htmlOptions' => array('class' => 'well form-vertical')
)); ?>

<div class="alert alert-info"><?php echo Yii::t('yupe','Поля, отмеченные');?> <span class="required">*</span> <?php echo Yii::t('yupe','обязательны.');?></div>

	<?php echo  $form->errorSummary($model); ?>

	<div class='row-fluid control-group <?php echo $model->hasErrors("category_id")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'category_id',array('class'=>'span5','maxlength'=>10,'size' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("name")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150,'size' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("price")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'price',array('class'=>'span5','size' => 60,'maxlength' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("article")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'article',array('class'=>'span5','maxlength'=>100,'size' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("image")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'image',array('class'=>'span5','maxlength'=>300,'size' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("short_description")?"error":"" ?>'><?php echo  $form->textAreaRow($model,'short_description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("description")?"error":"" ?>'><?php echo  $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("alias")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'alias',array('class'=>'span5','maxlength'=>100,'size' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("data")?"error":"" ?>'><?php echo  $form->textAreaRow($model,'data',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("status")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'status',array('class'=>'span5','size' => 60,'maxlength' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("create_time")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'create_time',array('class'=>'span5','size' => 60,'maxlength' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("update_time")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'update_time',array('class'=>'span5','size' => 60,'maxlength' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("user_id")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>10,'size' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("change_user_id")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'change_user_id',array('class'=>'span5','maxlength'=>10,'size' => 60)); ?></div>

	
<?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=>$model->isNewRecord ? Yii::t('yupe','Создать товар') : Yii::t('yupe','Сохранить товар'),
)); ?>
	

<?php $this->endWidget(); ?>
