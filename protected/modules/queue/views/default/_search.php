<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'=> Yii::app()->createUrl($this->route),
    'method'=> 'get',
)); ?>

<?php echo $form->textFieldRow($model, 'id', array('class' => 'span5', 'maxlength'=> 10)); ?>

<?php echo $form->textFieldRow($model, 'worker', array('class' => 'span5', 'maxlength'=> 300)); ?>

<?php echo $form->textFieldRow($model, 'create_time', array('class'=> 'span5')); ?>

<?php echo $form->textAreaRow($model, 'task', array('rows' => 6, 'cols' => 50, 'class'=> 'span8')); ?>

<?php echo $form->textFieldRow($model, 'start_time', array('class'=> 'span5')); ?>

<?php echo $form->textFieldRow($model, 'complete_time', array('class'=> 'span5')); ?>

<?php echo $form->textFieldRow($model, 'status', array('class'=> 'span5')); ?>

<?php echo $form->textFieldRow($model, 'notice', array('class' => 'span5', 'maxlength'=> 300)); ?>

<div class="form-actions">
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type' => 'primary',
    'label'=> 'Search',
)); ?>
</div>

<?php $this->endWidget(); ?>
