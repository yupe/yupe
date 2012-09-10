<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'vertical',
        'htmlOptions' => array('class' => 'well form-vertical')
)); ?>
<fieldset class="inline">    
	<?php echo  $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>11,'size' => 60)); ?>

	<?php echo  $form->textFieldRow($model,'category_id',array('class'=>'span5','maxlength'=>10,'size' => 60)); ?>

	<?php echo  $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150,'size' => 60)); ?>

	<?php echo  $form->textFieldRow($model,'price',array('class'=>'span5','size' => 60,'maxlength' => 60)); ?>

	<?php echo  $form->textFieldRow($model,'article',array('class'=>'span5','maxlength'=>100,'size' => 60)); ?>

	<?php echo  $form->textFieldRow($model,'image',array('class'=>'span5','maxlength'=>300,'size' => 60)); ?>

	<?php echo  $form->textAreaRow($model,'short_description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo  $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo  $form->textFieldRow($model,'alias',array('class'=>'span5','maxlength'=>100,'size' => 60)); ?>

	<?php echo  $form->textAreaRow($model,'data',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo  $form->textFieldRow($model,'status',array('class'=>'span5','size' => 60,'maxlength' => 60)); ?>

	<?php echo  $form->textFieldRow($model,'create_time',array('class'=>'span5','size' => 60,'maxlength' => 60)); ?>

	<?php echo  $form->textFieldRow($model,'update_time',array('class'=>'span5','size' => 60,'maxlength' => 60)); ?>

	<?php echo  $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>10,'size' => 60)); ?>

	<?php echo  $form->textFieldRow($model,'change_user_id',array('class'=>'span5','maxlength'=>10,'size' => 60)); ?>

</fieldset>    
	
<?php $this->widget('bootstrap.widgets.TbButton', array(
                        'type'=>'primary',
                        'encodeLabel' => false,
                        'buttonType' => 'submit',
                        'label'=>'<i class="icon-search icon-white"></i> '.Yii::t('yupe','Искать'),
                )); ?>
	

<?php $this->endWidget(); ?>
