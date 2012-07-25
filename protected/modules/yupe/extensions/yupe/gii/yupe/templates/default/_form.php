<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo  "<?php \$form=\$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
	'type'=>'vertical',
        'htmlOptions' => array('class' => 'well form-vertical')
)); ?>\n"; ?>

<div class="alert alert-info"><?php echo "<?php echo Yii::t('yupe','Поля, отмеченные');?>";?> <span class="required">*</span> <?php echo "<?php echo Yii::t('yupe','обязательны.');?>";?></div>

	<?php echo  "<?php echo  \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
?>
	<?php echo  "<div class='row-fluid control-group <?php echo \$model->hasErrors(\"{$column->name}\")?\"error\":\"\" ?>'><?php echo  ".$this->generateActiveRow($this->modelClass,$column)."; ?></div>\n"; ?>

<?php
}
?>
	
<?php echo  "<?php \$this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=>\$model->isNewRecord ? Yii::t('yupe','Добавить $this->vin') : Yii::t('yupe','Сохранить $this->vin'),
)); ?>\n"; ?>
	

<?php echo  "<?php \$this->endWidget(); ?>\n"; ?>
