<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'queue-form',
    'enableAjaxValidation'=> false,
    'htmlOptions' => array('class' => 'well form-vertical'),
)); ?>

<div class="alert alert-info">Поля, отмеченные звездочкой <span class="required">*</span> обязательны.</div>

<?php echo $form->errorSummary($model); ?>

<div class='control-group <?php echo $model->hasErrors("worker") ? "error" : "" ?>'><?php echo $form->textFieldRow($model, 'worker', array('class' => 'span5', 'maxlength'=> 300)); ?></div>

<div class='control-group <?php echo $model->hasErrors("task") ? "error" : "" ?>'><?php echo $form->textAreaRow($model, 'task', array('rows' => 6, 'cols' => 50, 'class'=> 'span8')); ?></div>

<div class='control-group <?php echo $model->hasErrors("notice") ? "error" : "" ?>'><?php echo $form->textFieldRow($model, 'notice', array('class' => 'span5', 'maxlength'=> 300)); ?></div>

<div class='control-group <?php echo $model->hasErrors("priority") ? "error" : "" ?>'><?php echo $form->dropDownListRow($model, 'priority', $model->getPriorityList(), array('class'=> 'span5')); ?></div>

<div class='control-group <?php echo $model->hasErrors("status") ? "error" : "" ?>'><?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class'=> 'span5')); ?></div>


<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type'       => 'primary',
    'label'      => $model->isNewRecord ? Yii::t('queue','Добавить задание') : Yii::t('queue','Сохранить задание'),
)); ?>


<?php $this->endWidget(); ?>
