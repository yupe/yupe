<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'vertical',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>


<fieldset class="inline">
    <div class="row-fluid control-group">
        <div class="span3">
            <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('empty' => Yii::t('CommentModule.comment', '--choose--'),)); ?>
        </div>

        <div class="span3">
            <?php echo $form->textFieldRow($model, 'model', array('size' => 60, 'maxlength' => 150)); ?>
        </div>

        <div class="span3">
            <?php echo $form->textFieldRow($model, 'model_id', array('size' => 60, 'maxlength' => 150)); ?>
        </div>
    </div>

    <div class="row-fluid control-group">

        <div class="span3">
            <?php echo $form->textFieldRow($model, 'name', array('size' => 60, 'maxlength' => 150)); ?>
        </div>

        <div class="span3">
            <?php echo $form->textFieldRow($model, 'email', array('size' => 60, 'maxlength' => 150)); ?>
        </div>

        <div class="span3">
            <?php echo $form->textFieldRow($model, 'url', array('size' => 60, 'maxlength' => 150)); ?>
        </div>

    </div>

    <div class="row-fluid control-group">

        <div class="span3">
            <?php echo $form->datepickerRow($model, 'creation_date', array(
                    'options' => array(
                        'format' => 'dd-mm-yyyy',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ),
                ),
                array(
                    'prepend' => '<i class="icon-calendar"></i>',
                ));
            ?>
        </div>

        <div class="span3">
            <?php echo $form->textFieldRow($model, 'text', array('size' => 60, 'maxlength' => 150)); ?>
        </div>

        <div class="span3">
            <?php echo $form->textFieldRow($model, 'ip', array('size' => 20, 'maxlength' => 20)); ?>
        </div>

    </div>

</fieldset>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'type' => 'primary',
        'encodeLabel' => false,
        'buttonType' => 'submit',
        'label' => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('CommentModule.comment', 'Find comments'),
    )
); ?>

<?php $this->endWidget(); ?>
