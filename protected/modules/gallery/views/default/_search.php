<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'vertical',
        'htmlOptions' => array('class' => 'well form-vertical')
)); ?>
<fieldset class="inline">    
	<?php echo  $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>10,'size' => 60)); ?>

	<?php echo  $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>300,'size' => 60)); ?>

	<?php echo  $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo  $form->textFieldRow($model,'status',array('class'=>'span5','size' => 60,'maxlength' => 60)); ?>

</fieldset>    
	
<?php $this->widget('bootstrap.widgets.TbButton', array(
                        'type'=>'primary',
                        'encodeLabel' => false,
                        'buttonType' => 'submit',
                        'label'=>'<i class="icon-search icon-white"></i> '.Yii::t('gallery','Искать'),
                )); ?>
	

<?php $this->endWidget(); ?>
