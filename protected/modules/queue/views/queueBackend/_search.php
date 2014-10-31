<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>
<fieldset>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'worker',
                array(
                    'widgetOptions' => array(
                        'data'        => Yii::app()->getModule('queue')->getWorkerNamesMap(),
                        'htmlOptions' => array('empty' => '---'),
                    ),
                )
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'priority',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->getPriorityList(),
                        'htmlOptions' => array('empty' => '---'),
                    ),
                )
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'status',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->getStatusList(),
                        'htmlOptions' => array('empty' => '---'),
                    ),
                )
            ); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->datePickerGroup(
                $model,
                'create_time',
                array(
                    'widgetOptions' => array(
                        'options' => array(
                            'format'    => 'dd-mm-yyyy',
                            'weekStart' => 1,
                            'autoclose' => true,
                        ),
                    ),
                    'prepend'       => '<i class="fa fa-calendar"></i>',
                )
            );
            ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->datePickerGroup(
                $model,
                'start_time',
                array(
                    'widgetOptions' => array(
                        'options' => array(
                            'format'    => 'dd-mm-yyyy',
                            'weekStart' => 1,
                            'autoclose' => true,
                        ),
                    ),
                    'prepend'       => '<i class="fa fa-calendar"></i>',
                )
            );
            ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->datePickerGroup(
                $model,
                'complete_time',
                array(
                    'widgetOptions' => array(
                        'options' => array(
                            'format'    => 'dd-mm-yyyy',
                            'weekStart' => 1,
                            'autoclose' => true,
                        ),
                    ),
                    'prepend'       => '<i class="fa fa-calendar"></i>',
                )
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
    array(
        'context'     => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t('QueueModule.queue', 'Find task'),
    )
); ?>

<?php $this->endWidget(); ?>
