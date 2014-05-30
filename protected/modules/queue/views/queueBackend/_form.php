<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'queue-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
)); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('QueueModule.queue', 'Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('QueueModule.queue', 'are required'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class='control-group <?php echo $model->hasErrors("worker") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'worker', Yii::app()->getModule('queue')->getWorkerNamesMap(), array('class' => 'span7', 'maxlength'=> 11, 'empty' => '---')); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("task") ? "error" : ""; ?>'>
        <?php echo $form->textAreaRow($model, 'task', array('rows' => 6, 'cols' => 50, 'class'=> 'span7')); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("notice") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'notice', array('class' => 'span7', 'maxlength'=> 255)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("priority") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'priority', $model->priorityList, array('class'=> 'span7')); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("status") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList, array('class'=> 'span7')); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('QueueModule.queue', 'Create task and continue') : Yii::t('QueueModule.queue', 'Save task'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('QueueModule.queue', 'Create task and close') : Yii::t('QueueModule.queue', 'Save blog and close'),
    )); ?>

<?php $this->endWidget(); ?>
