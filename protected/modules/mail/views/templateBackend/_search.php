<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'htmlOptions' => array('class' => 'well search-form'),
    )
);
?>
<fieldset>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'name'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'code'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'event_id',
                array(
                    'widgetOptions' => array(
                        'data'        => CHtml::listData(MailEvent::model()->findAll(), 'id', 'name'),
                        'htmlOptions' => array('empty' => '---'),
                    ),
                )
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'description'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'from'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'to'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'theme'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'body'); ?>
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
    <div class="form-actions">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType'  => 'submit',
                'context'     => 'primary',
                'encodeLabel' => false,
                'label'       => '<i class="fa fa-search"></i> ' . Yii::t('MailModule.mail', 'Find')
            )
        );
        ?>
    </div>
</fieldset>

<?php $this->endWidget(); ?>
