<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'queue-form',
    'enableAjaxValidation'=> false,
    'htmlOptions' => array('class' => 'well form-vertical'),
)); ?>

<div class="alert alert-info"> <?php echo Yii::t('queue','Поля, отмеченные');?> <span class="required">*</span><?php echo Yii::t('queue','обязательны для заполнения')?></div>

<?php echo $form->errorSummary($model); ?>

<div class='control-group <?php echo $model->hasErrors("worker") ? "error" : "" ?>'><?php echo $form->textFieldRow($model, 'worker', array('class' => 'span7', 'maxlength'=> 300)); ?></div>

<div class='control-group <?php echo $model->hasErrors("task") ? "error" : "" ?>'><?php echo $form->textAreaRow($model, 'task', array('rows' => 6, 'cols' => 50, 'class'=> 'span8')); ?></div>

<div class='control-group <?php echo $model->hasErrors("notice") ? "error" : "" ?>'><?php echo $form->textFieldRow($model, 'notice', array('class' => 'span7', 'maxlength'=> 300)); ?></div>

<div class='control-group <?php echo $model->hasErrors("priority") ? "error" : "" ?>'><?php echo $form->dropDownListRow($model, 'priority', $model->getPriorityList(), array('class'=> 'span7')); ?></div>

<div class='control-group <?php echo $model->hasErrors("status") ? "error" : "" ?>'><?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class'=> 'span7')); ?></div>


<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type'       => 'primary',
    'label'      => $model->isNewRecord ? Yii::t('queue','Добавить задание и продолжить') : Yii::t('queue','Сохранить задание'),
)); ?>

  <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
        'label'      => $model->isNewRecord ? Yii::t('queue', 'Добавить задание и закрыть') : Yii::t('queue', 'Сохранить блог и закрыть'),
    )); ?>


<?php $this->endWidget(); ?>
