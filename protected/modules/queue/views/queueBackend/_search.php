<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => ['class' => 'well'],
    ]
); ?>
<fieldset>
    <div class="row">
        <div class="col-sm-3">
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
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'priority',
                [
                    'widgetOptions' => [
                        'data'        => $model->getPriorityList(),
                        'htmlOptions' => ['empty' => '---'],
                    ],
                ]
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'status',
                [
                    'widgetOptions' => [
                        'data'        => $model->getStatusList(),
                        'htmlOptions' => ['empty' => '---'],
                    ],
                ]
            ); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->datePickerGroup(
                $model,
                'create_time',
                [
                    'widgetOptions' => [
                        'options' => [
                            'format'    => 'dd-mm-yyyy',
                            'weekStart' => 1,
                            'autoclose' => true,
                        ],
                    ],
                    'prepend'       => '<i class="fa fa-calendar"></i>',
                ]
            );
            ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->datePickerGroup(
                $model,
                'start_time',
                [
                    'widgetOptions' => [
                        'options' => [
                            'format'    => 'dd-mm-yyyy',
                            'weekStart' => 1,
                            'autoclose' => true,
                        ],
                    ],
                    'prepend'       => '<i class="fa fa-calendar"></i>',
                ]
            );
            ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->datePickerGroup(
                $model,
                'complete_time',
                [
                    'widgetOptions' => [
                        'options' => [
                            'format'    => 'dd-mm-yyyy',
                            'weekStart' => 1,
                            'autoclose' => true,
                        ],
                    ],
                    'prepend'       => '<i class="fa fa-calendar"></i>',
                ]
            );
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'task'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'notice'); ?>
        </div>
    </div>

</fieldset>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'context'     => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t('QueueModule.queue', 'Find task'),
    ]
); ?>

<?php $this->endWidget(); ?>
