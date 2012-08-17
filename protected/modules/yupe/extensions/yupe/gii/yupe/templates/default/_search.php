<?php echo  "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl(\$this->route),
	'method'=>'get',
        'type'=>'vertical',
        'htmlOptions' => array('class' => 'well form-vertical')
)); ?>\n"; ?>
<fieldset class="inline">    
<?php foreach($this->tableSchema->columns as $column): ?>
<?php
	$field=$this->generateInputField($this->modelClass,$column);
	if(strpos($field,'password')!==false)
		continue;
?>
	<?php echo  "<?php echo  ".$this->generateActiveRow($this->modelClass,$column)."; ?>\n"; ?>

<?php endforeach; ?>
</fieldset>    
	
<?php echo  "<?php \$this->widget('bootstrap.widgets.TbButton', array(
                        'type'=>'primary',
                        'encodeLabel' => false,
                        'buttonType' => 'submit',
                        'label'=>'<i class=\"icon-search icon-white\"></i> '.Yii::t('{$this->mid}','Искать'),
                )); ?>\n"; ?>
	

<?php echo  "<?php \$this->endWidget(); ?>\n"; ?>