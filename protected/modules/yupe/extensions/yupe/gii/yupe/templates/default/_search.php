<?php echo  "<?php \$form=\$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl(\$this->route),
	'method'=>'get',
)); ?>\n"; ?>

<?php foreach($this->tableSchema->columns as $column): ?>
<?php
	$field=$this->generateInputField($this->modelClass,$column);
	if(strpos($field,'password')!==false)
		continue;
?>
	<?php echo  "<?php echo  ".$this->generateActiveRow($this->modelClass,$column)."; ?>\n"; ?>

<?php endforeach; ?>
	<div class="form-actions">
		<?php echo  "<?php \$this->widget('bootstrap.widgets.BootButton', array(
                                        'type'=>'primary',
                                        'encodeLabel' => false,
                                        'label'=>'<i class=\"icon-search icon-white\"></i> '.Yii::t('yupe','Искать'),
                                )); ?>\n"; ?>
	</div>

<?php echo  "<?php \$this->endWidget(); ?>\n"; ?>