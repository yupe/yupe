<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array('class' => 'well search-form'),
    )
);
?>
<fieldset class="inline">

    <div class="row-fluid control-group">

        <div class="span3">
            <?php echo $form->textFieldRow($model, 'name', array('maxlength' => 300)); ?>
        </div>

        <div class="span3">
            <?php echo $form->textFieldRow($model, 'code', array('maxlength' => 100)); ?>
        </div>

        <div class="span3">
            <?php echo $form->dropDownListRow($model, 'event_id',CHtml::listData(MailEvent::model()->findAll(), 'id', 'name'), array('empty' => '---','maxlength' => 10)); ?>
        </div>

    </div>

    <div class="row-fluid control-group">

        <div class="span3">
           <?php echo $form->textFieldRow($model, 'description'); ?>
        </div>

        <div class="span3">
            <?php echo $form->textFieldRow($model, 'from', array('maxlength' => 300)); ?>
        </div>

        <div class="span3">
            <?php echo $form->textFieldRow($model, 'to', array('maxlength' => 300)); ?>
        </div>

    </div>

    <div class="row-fluid control-group">

        <div class="span3">
            <?php echo $form->textFieldRow($model, 'theme'); ?>
        </div>

        <div class="span3">
            <?php echo $form->textFieldRow($model, 'body'); ?>
        </div>

        <div class="span3">
            <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('empty' => '---')); ?>
        </div>

    </div>

    <div class="form-actions">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'encodeLabel' => false,
                'label' => '<i class="icon-search icon-white"></i> ' . Yii::t('MailModule.mail', 'Find')
            )
        );
        ?>
    </div>
</fieldset>

<?php $this->endWidget(); ?>
