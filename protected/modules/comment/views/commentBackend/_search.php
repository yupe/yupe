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
                'status',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->getStatusList(),
                        'htmlOptions' => array(
                            'empty' => Yii::t('CommentModule.comment', '--choose--'),
                        ),
                    ),
                )
            ); ?>
        </div>

        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'model'); ?>
        </div>

        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'model_id'); ?>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'name'); ?>
        </div>

        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'email'); ?>
        </div>

        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'url'); ?>
        </div>

    </div>

    <div class="row">

        <div class="col-sm-3">
            <?php echo $form->datePickerGroup(
                $model,
                'creation_date',
                array(
                    'widgetOptions' => array(
                        'options' => array(
                            'format'    => 'yyyy-mm-dd',
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
            <?php echo $form->textFieldGroup($model, 'text'); ?>
        </div>

        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'ip'); ?>
        </div>

    </div>

</fieldset>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'context'     => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t(
                'CommentModule.comment',
                'Find comments'
            ),
    )
); ?>

<?php $this->endWidget(); ?>
