<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'                     => 'queue-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well'],
    ]
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('QueueModule.queue', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('QueueModule.queue', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'worker',
            [
                'widgetOptions' => [
                    'data'        => Yii::app()->getModule('queue')->getWorkerNamesMap(),
                    'htmlOptions' => ['empty' => '---'],
                ],
            ]
        ); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textAreaGroup($model, 'task'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'notice'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'priority',
            [
                'widgetOptions' => [
                    'data' => $model->getPriorityList(),
                ],
            ]
        ); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data' => $model->getStatusList(),
                ],
            ]
        ); ?>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('QueueModule.queue', 'Create task and continue') : Yii::t(
                'QueueModule.queue',
                'Save task'
            ),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t('QueueModule.queue', 'Create task and close') : Yii::t(
                'QueueModule.queue',
                'Save blog and close'
            ),
    ]
); ?>

<?php $this->endWidget(); ?>
