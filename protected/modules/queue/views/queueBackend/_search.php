<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well form-vertical'),
)); ?>
    <fieldset class="inline">
        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'worker', Yii::app()->getModule('queue')->getWorkerNamesMap(), array('maxlength'=> 300, 'empty' => '---')); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'priority', $model->getPriorityList(), array('empty' => '---')); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('empty' => '---')); ?>
            </div>
        </div>

        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'create_time'); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'start_time'); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'complete_time'); ?>
            </div>
        </div>

        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'task', array('rows' => 6, 'cols' => 50)); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'notice', array('maxlength'=> 300)); ?>
            </div>
        </div>

    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('QueueModule.queue', 'Find task'),
    )); ?>

<?php $this->endWidget(); ?>
